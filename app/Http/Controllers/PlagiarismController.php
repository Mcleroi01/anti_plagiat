<?php

namespace App\Http\Controllers;

use App\Models\Plagiarism;
use App\Http\Requests\StorePlagiarismRequest;
use App\Http\Requests\UpdatePlagiarismRequest;
use GuzzleHttp\Client;
use App\Models\Document;
use App\Models\SearchResult;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;

class PlagiarismController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function detect(Document $document)
    {
        $normalizedPath = public_path('storage/' . $document->path);
        $documentId = $document->id;
        if (!file_exists($normalizedPath)) {
            Log::error("Fichier non trouvé : " . $normalizedPath);
            return response()->json(['error' => 'Fichier non trouvé.'], 404);
        }

        try {
            Log::info("Début du traitement pour le fichier : " . $normalizedPath);

            $parser = new Parser();
            $pdf = $parser->parseFile($normalizedPath);
            $text = $pdf->getText();

            // Log après l'extraction du texte
            Log::info("Texte extrait du PDF, longueur du texte : " . strlen($text));

            // Nettoyage du texte : suppression des numéros de section
            $text = preg_replace('/\b\d+\.\s*/', '', $text); // Supprime les numéros sous forme de 1. ou 2.
            $text = preg_replace('/\b(?:I{1,3}|IV|V|VI{0,3}|IX|X{1,3})\.\s*/', '', $text); // Supprime les numéros romains
            $text = preg_replace('/\b(?:année académique|préambule|liste des tableaux|ENSEIGNEMENT SUPERIEUR ET UNIVERSITAIRE INSTITUT SUPERIEUR|défendu en vue de lobtention du|république démocratique du congo|chap|remerciements|introduction|chapitre|annexe|bibliographie|table|objectif général|forces et faiblesses de l’étude|dédicaces|table des matières|généralités sur le sujet|of\scontents)\b/i', '', $text); // Supprime les phrases non pertinentes

            // Nettoyage du texte : suppression des caractères non pertinents
            $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text); // Enlève les caractères non pertinents, y compris les points
            $text = preg_replace('/\s+/', ' ', $text); // Normalise les espaces
            $text = trim($text); // Retire les espaces inutiles
            $text = preg_replace('/^\s*\n/m', '', $text); // Enlève les lignes vides

            // Log après nettoyage
            Log::info("Texte après nettoyage, longueur du texte : " . strlen($text));



            Log::info("Texte après nettoyage, longueur du texte : " . strlen($text));

            $words = explode(' ', $text);
            $segments = [];
            $currentSegment = [];

            // Create segments of 300 words
            foreach ($words as $word) {
                $currentSegment[] = $word;


                if (count($currentSegment) >= 300) {
                    $segments[] = implode(' ', $currentSegment);
                    $currentSegment = []; // Reset for the next segment
                }
            }

            // In case there are remaining words in the current segment, we can add them too
            if (count($currentSegment) > 0) {
                $segments[] = implode(' ', $currentSegment);
            }

            Log::info("Nombre de segments créés : " . count($segments));

            $totalSimilarity = 0;
            $totalSegments = 0;

            set_time_limit(11300);

            $resultsToStore = [];
            $totalSimilarity = 0;
            $totalSegments = 0;

            foreach ($segments as $segment) {
                Log::info("Traitement du segment : " . substr($segment, 0, 50) . "...");

                if (strlen(trim($segment)) < 10) {
                    Log::info("Segment trop court, ignoré.");
                    continue;
                }

                // Diviser le segment si nécessaire
                $splitSegments = $this->splitSegment(trim($segment), 2048);
                Log::info("Type de splitSegments : " . gettype($splitSegments));

                foreach ($splitSegments as $splitSegment) {  // Ici on parcourt $splitSegments
                    Log::info("Recherche de similarité pour le segment : " . substr($splitSegment, 0, 50) . "...");
                    $searchResults = $this->searchSegment($splitSegment);

                    if (!empty($searchResults['organic'])) {
                        $segmentNormalized = strtolower(trim($splitSegment));
                        $snippetNormalized = strtolower(trim($searchResults['organic'][0]['snippet']));

                        Log::info("Comparaison : " . $segmentNormalized . ' et ' . $snippetNormalized);
                        $similarity = $this->calculateHybridSimilarity($segmentNormalized, $snippetNormalized);
                        Log::info("Similarité calculée : " . $similarity . "%");

                        if ($similarity >= 10) {
                            $totalSimilarity += $similarity;
                            $totalSegments++;
                            Log::info("Segment retenu avec une similarité de " . $similarity . "%");

                            $resultsToStore[] = [
                                'document_id' => $documentId,
                                'search_phrase' => $splitSegment,
                                'result_snippet' => $searchResults['organic'][0]['snippet'],
                                'similarity_calculated' => $similarity,
                                'result_link' => $searchResults['organic'][0]['link'],
                            ];
                        } else {
                            Log::info("Similarité inférieure à 10%, segment ignoré.");
                        }
                    } else {
                        Log::info("Segment traité : " . $splitSegment);
                        Log::info("Aucun résultat trouvé pour ce segment.");
                    }
                }
            }

            // Calcul de la similarité moyenne
            $averageSimilarity = $totalSegments > 0 ? $totalSimilarity / $totalSegments  : 0;

            // Ajouter la similarité globale calculée à chaque enregistrement
            foreach ($resultsToStore as &$result) {
                $result['global_similarity_calculated'] = $averageSimilarity;
            }

            foreach ($resultsToStore as $result) {
                $searchResult = SearchResult::create($result);
            }

            return response()->json([
                'success' => true,
                'message' => 'Détection de plagiat terminée',
                'average_similarity' => $averageSimilarity,
                'text' => $text,
                'results' => $resultsToStore
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la détection de plagiat : " . $e->getMessage());
            return response()->json(['error' => 'Erreur de lecture du PDF : ' . $e->getMessage()], 500);
        }
    }

    private function splitSegment($segment, $maxLength = 2048)
    {
        $chunks = [];
        if (strlen($segment) > $maxLength) {
            $currentChunk = '';

            foreach (explode(' ', $segment) as $word) {
                if (strlen($currentChunk) + strlen($word) + 1 > $maxLength) {
                    $chunks[] = trim($currentChunk);
                    $currentChunk = '';
                }

                $currentChunk .= $word . ' ';
            }


            if (!empty(trim($currentChunk))) {
                $chunks[] = trim($currentChunk);
            }
        } else {

            $chunks[] = trim($segment);
        }

        return $chunks;
    }





    private function searchSegment($segment)
    {
        $client = new Client();
        $headers = [
            'X-API-KEY' => '8b4d156e7b697db38cebed8eeb11d20256d3af1a',
            'Content-Type' => 'application/json',

        ];

        $body = json_encode([
            'q' => $segment,
            "hl" => "fr"
        ]);

        try {
            $response = $client->post('https://google.serper.dev/search', [
                'headers' => $headers,
                'body' => $body,
                'verify' => false,
            ]);

            Log::info('API response:', ['body' => $response->getBody()->getContents()]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche : ' . $e->getMessage());
            return [
                'error' => 'Erreur lors de la recherche : ' . $e->getMessage(),
            ];
        }
    }



    private function calculateHybridSimilarity($text1, $text2, $n = 2) // Par défaut, n = 2 pour des bigrams
    {
        // Normaliser les textes
        $text1 = $this->normalizeText($text1);
        $text2 = $this->normalizeText($text2);

        // Éviter de calculer la similarité si les deux textes sont vides
        if (empty($text1) && empty($text2)) {
            return 100; // Deux textes vides sont considérés comme identiques
        }

        // Utiliser similar_text() pour une évaluation rapide
        similar_text($text1, $text2, $similarityPercentage);

        // Ajuster le seuil si nécessaire
        if ($similarityPercentage > 50) { // Ajustez ce seuil
            return $similarityPercentage; // Retourner la similarité élevée sans calculer Levenshtein
        }

        // Générer les n-grams pour chaque texte
        $nGrams1 = $this->nGrams($text1, $n);
        $nGrams2 = $this->nGrams($text2, $n);

        // Utiliser un ensemble pour les n-grams du deuxième texte pour améliorer la recherche
        $nGramSet = array_unique($nGrams2);

        $totalSimilarity = 0;
        $nGramCount = 0;

        foreach ($nGrams1 as $nGram) {
            $closest = null;
            $shortest = -1;

            foreach ($nGramSet as $nGramComp) {
                $lev = levenshtein($nGram, $nGramComp);

                // Cherche une correspondance exacte
                if ($lev == 0) {
                    $closest = $nGramComp;
                    $shortest = 0;
                    break;
                }

                if ($lev <= $shortest || $shortest < 0) {
                    $closest = $nGramComp;
                    $shortest = $lev;
                }
            }

            // Calculer la similarité basée sur la distance Levenshtein
            if ($closest !== null) {
                $nGramLength = strlen($nGram);
                $closestLength = strlen($closest);

                if ($nGramLength > 0 && $closestLength > 0) {
                    $similarityLevenshtein = (1 - $shortest / max($nGramLength, $closestLength)) * 100;
                    $totalSimilarity += $similarityLevenshtein;
                    $nGramCount++;
                }
            }
        }

        return $nGramCount > 0 ? $totalSimilarity / $nGramCount : 0;
    }

    private function nGrams($text, $n)
    {
        $words = explode(' ', $text);
        $nGrams = [];
        for ($i = 0; $i <= count($words) - $n; $i++) {
            $nGrams[] = implode(' ', array_slice($words, $i, $n));
        }
        return $nGrams;
    }



    private function normalizeText($text)
    {

        $text = preg_replace('/[^\w\s]/u', '', $text);

        return $text;
    }
}
