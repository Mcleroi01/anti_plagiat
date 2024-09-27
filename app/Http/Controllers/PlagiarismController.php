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

            // Nettoyage du texte : suppression des chiffres et des phrases non pertinentes
            $text = str_replace('. ', 'TEMP_DELIM', $text);

            // Supprimer les numéros de section
            $text = preg_replace('/\b\d+\.\s*/', '', $text);
            $text = preg_replace('/\b(?:I{1,3}|IV|V|VI{0,3}|IX|X{1,3})\.\s*/', '', $text);
            $text = preg_replace('/\b(?:année académique|préambule|liste des tableaux|république démocratique du congo|chap|remerciements|introduction|chapitre|annexe|bibliographie|table|objectif général|forces et faiblesses de l’étude|dédicaces|table des matières|généralités sur le sujet|of\scontents)\b/i', '', $text);

            // Conserver les points et espaces dans le texte
            $text = preg_replace('/[^\p{L}\p{N}\s\.]/u', '', $text);
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);
            $text = preg_replace('/^\s*\n/m', '', $text);

            Log::info("Texte après nettoyage, longueur du texte : " . strlen($text));

            $text = str_replace('TEMP_DELIM', '. ', $text);
            $segments = explode(". ", $text);

            $totalSimilarity = 0;
            $totalSegments = 0;

            set_time_limit(11300);

            $resultsToStore = [];
            $totalSimilarity = 0;
            $totalSegments = 0;

            foreach ($segments as $segment) {
                Log::info("Traitement du segment : " . substr($segment, 0, 50) . "...");

                if (strlen(trim($segment)) < 20) {
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
                        $similarity = $this->calculateSimilarity($segmentNormalized, $snippetNormalized);
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
            $averageSimilarity = $totalSegments > 0 ? ($totalSimilarity / $totalSegments) * 100 : 0;

            // Ajouter la similarité globale calculée à chaque enregistrement
            foreach ($resultsToStore as &$result) {
                $result['global_similarity_calculated'] = $averageSimilarity;
            }
            $resultIds=[];
            // Insérer chaque enregistrement dans la base de données
            foreach ($resultsToStore as $result) {
                $searchResult=SearchResult::create($result);
                $resultIds[] = $searchResult->id;
            }

            Log::info("Tous les résultats ont été enregistrés avec une similarité globale calculée de : " . $averageSimilarity . "%");


            Log::info("Détection de plagiat terminée, similarité moyenne : " . $averageSimilarity . "%");

            return $resultIds;
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
            'X-API-KEY' => 'f7f0f0f49c574a659436348e982705b2a90ea958',
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



    private function calculateSimilarity($text1, $text2)
    {
        // Normaliser les textes
        $text1 = $this->normalizeText($text1);
        $text2 = $this->normalizeText($text2);

        // Éviter de calculer la similarité si les deux textes sont vides
        if (empty($text1) && empty($text2)) {
            return 100; // Deux textes vides sont considérés comme identiques
        }

        // Diviser les textes en mots
        $words1 = explode(' ', $text1);
        $words2 = explode(' ', $text2);

        // Variables pour stocker les similarités
        $totalSimilarity = 0;
        $wordCount = 0;

        // Comparer chaque mot dans le premier texte avec chaque mot dans le second texte
        foreach ($words1 as $input) {
            $closest = null;
            $shortest = -1;

            foreach ($words2 as $word) {
                // Calcul de la distance de Levenshtein
                $lev = levenshtein($input, $word);

                // Cherche une correspondance exacte
                if ($lev == 0) {
                    $closest = $word;
                    $shortest = 0;
                    break; // Sortir de la boucle, correspondance exacte trouvée
                }

                // Si la distance est plus petite que la prochaine distance trouvée
                if ($lev <= $shortest || $shortest < 0) {
                    $closest = $word;
                    $shortest = $lev;
                }
            }


            // Calculer la similarité pour ce mot
            if ($closest !== null) {
                $inputLength = strlen($input);
                $closestLength = strlen($closest);

                // Vérifier si les longueurs sont supérieures à zéro
                if ($inputLength > 0 && $closestLength > 0) {
                    $similarityLevenshtein = (1 - $shortest / max($inputLength, $closestLength)) * 100;
                    $totalSimilarity += $similarityLevenshtein;
                    $wordCount++;
                } else {
                    Log::warning("Une des chaînes est vide. Input: '{$input}', Closest: '{$closest}'");
                }
            }
        }

        // Calculer la similarité finale
        if ($wordCount > 0) {
            $finalSimilarity = $totalSimilarity / $wordCount;
        } else {
            $finalSimilarity = 0; // Aucun mot trouvé
        }

        return $finalSimilarity;
    }






    private function normalizeText($text)
    {

        $text = strtolower($text);


        $text = trim(preg_replace('/\s+/', ' ', $text));


        $text = preg_replace('/[^\w\s]/u', '', $text);

        return $text;
    }
}
