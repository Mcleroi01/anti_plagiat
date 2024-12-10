<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Document;
use App\Models\Plagiarism;
use App\Models\SearchResult;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePlagiarismRequest;
use App\Http\Requests\UpdatePlagiarismRequest;

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

            $extension = strtolower(pathinfo($normalizedPath, PATHINFO_EXTENSION));
            $text = '';

            // Gestion des différents types de fichiers
            switch ($extension) {
                case 'pdf':
                    $parser = new Parser();
                    $pdf = $parser->parseFile($normalizedPath);
                    $text = $pdf->getText();
                    break;

                case 'docx':
                    $phpWord = IOFactory::load($normalizedPath);

                    // Parcourir toutes les sections du document Word
                    foreach ($phpWord->getSections() as $section) {
                        $elements = $section->getElements();

                        foreach ($elements as $element) {
                            if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $element->getText() . ' ';
                            } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                foreach ($element->getElements() as $textElement) {
                                    if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                        $text .= $textElement->getText() . ' ';
                                    }
                                }
                            }
                        }
                    }
                    break;


                case 'txt':
                    $text = file_get_contents($normalizedPath);
                    break;

                default:
                    Log::error("Type de fichier non pris en charge : " . $extension);
                    return response()->json(['error' => 'Type de fichier non pris en charge.'], 415);
            }

            if (empty($text)) {
                Log::error("Impossible d'extraire le texte du fichier.");
                return response()->json(['error' => 'Aucun texte détecté dans le fichier.'], 400);
            }

            Log::info("Texte extrait, longueur : " . strlen($text));

            // Nettoyage du texte (réutilisez vos regex et logique ici)
            $text = $this->cleanText($text);

            Log::info("Texte nettoyé, longueur : " . strlen($text));

            // Traitement de segments et détection de similarité
            $processedData = $this->processSegments($text, $documentId);
            $highlightedText = $this->highlightPlagiarizedText($processedData['text'], $processedData['results']);

            return response()->json([
                'success' => true,
                'message' => 'Traitement terminé',
                'average_similarity' => $processedData['average_similarity'],
                'results' => $processedData['results'],
                'highlighted_text' => $highlightedText
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la détection de plagiat : " . $e->getMessage());
            return response()->json(['error' => 'Erreur de traitement du fichier : ' . $e->getMessage()], 500);
        }
    }


    private function cleanText($text)
    {
        // Nettoyage du texte : suppression des numéros de section
        $text = preg_replace('/\b\d+\.\s*/', '', $text); // Supprime les numéros sous forme de 1. ou 2.
        $text = preg_replace('/\b(?:I{1,3}|IV|V|VI{0,3}|IX|X{1,3})\.\s*/', '', $text); // Supprime les numéros romains
        $text = preg_replace('/\b(?:année académique|préambule|liste des tableaux|ENSEIGNEMENT SUPERIEUR ET UNIVERSITAIRE INSTITUT SUPERIEUR|défendu en vue de lobtention du|république démocratique du congo|chap|remerciements|introduction|chapitre|annexe|bibliographie|table|objectif général|forces et faiblesses de l’étude|dédicaces|table des matières|généralités sur le sujet|of\scontents)\b/i', '', $text); // Supprime les phrases non pertinentes

        // Nettoyage du texte : suppression des caractères non pertinents
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text); // Enlève les caractères non pertinents, y compris les points
        $text = preg_replace('/\s+/', ' ', $text); // Normalise les espaces
        $text = trim($text); // Retire les espaces inutiles
        $text = preg_replace('/^\s*\n/m', '', $text); // Enlève les lig
        return trim($text);
    }

    private function processSegments($text, $documentId)
    {
        $words = explode(' ', $text);
        $segments = [];
        $currentSegment = [];

        // Segmentation du texte en blocs de 300 mots
        foreach ($words as $word) {
            $currentSegment[] = $word;
            if (count($currentSegment) >= 300) {
                $segments[] = implode(' ', $currentSegment);
                $currentSegment = [];
            }
        }

        // Ajouter les mots restants dans un segment
        if (count($currentSegment) > 0) {
            $segments[] = implode(' ', $currentSegment);
        }

        Log::info("Nombre de segments créés : " . count($segments));

        $totalSimilarity = 0;
        $totalSegments = 0;
        $resultsToStore = [];

        // Allonger le temps d'exécution si nécessaire
        set_time_limit(300);

        // Parcourir chaque segment pour calculer la similarité
        foreach ($segments as $segment) {
            Log::info("Traitement du segment : " . substr($segment, 0, 50) . "...");

            if (strlen(trim($segment)) < 10) {
                Log::info("Segment trop court, ignoré.");
                continue;
            }

            // Diviser le segment si nécessaire
            $splitSegments = $this->splitSegment(trim($segment), 2048);

            foreach ($splitSegments as $splitSegment) {
                Log::info("Recherche de similarité pour le segment : " . substr($splitSegment, 0, 50) . "...");

                $searchResults = $this->searchSegment($splitSegment); // Méthode pour effectuer une recherche externe

                if (!empty($searchResults['organic'])) {
                    $segmentNormalized = strtolower(trim($splitSegment));
                    $snippetNormalized = strtolower(trim($searchResults['organic'][0]['snippet']));

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
                    Log::info("Aucun résultat trouvé pour ce segment.");
                }
            }
        }

        // Calcul de la similarité moyenne
        $averageSimilarity = $totalSegments > 0 ? $totalSimilarity / $totalSegments : 0;

        // Ajouter la similarité globale à chaque résultat
        foreach ($resultsToStore as &$result) {
            $result['global_similarity_calculated'] = $averageSimilarity;
        }

        // Sauvegarder les résultats dans la base de données
        foreach ($resultsToStore as $result) {
            SearchResult::create($result); // Assurez-vous que le modèle est configuré correctement
        }


        

        return [
            'success' => true,
            'message' => 'Traitement terminé',
            'average_similarity' => $averageSimilarity,
            'results' => $resultsToStore,
            'text' => $text
        ];
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

    private function highlightPlagiarizedText($text, $plagiarizedSegments)
    {
        // Liste des segments plagiés
        foreach ($plagiarizedSegments as $segment) {
            $searchPhrase = preg_quote($segment['search_phrase'], '/'); // Convertit le texte en un format compatible avec les expressions régulières
            $snippet = $segment['result_snippet'];

            // Remplace chaque occurrence du segment plagié par un surlignage HTML
            $highlightedSnippet = "<mark>" . htmlspecialchars($snippet) . "</mark>";
            $text = preg_replace(
                '/\b' . $searchPhrase . '\b/i',  // Recherche de l'occurrence exacte sans distinction de casse
                $highlightedSnippet,
                $text
            );
        }

        return $text;
    }

    private function searchSegment($segment)
    {
        $client = new Client();
        $headers = [
            'X-API-KEY' => 'c9af7b520b092b3bce8fc4d9a4de9a9589af3fe2',
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



    private function calculateHybridSimilarity($text1, $text2)
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
        if ($similarityPercentage > 70) { // Ajustez ce seuil
            return $similarityPercentage; // Retourner la similarité élevée sans calculer Levenshtein
        }

        // Diviser les textes en mots
        $words1 = explode(' ', $text1);
        $words2 = explode(' ', $text2);

        // Utiliser un ensemble pour les mots du deuxième texte pour améliorer la recherche
        $wordSet = array_unique($words2);

        $totalSimilarity = 0;
        $wordCount = 0;

        foreach ($words1 as $input) {
            $closest = null;
            $shortest = -1;

            foreach ($wordSet as $word) {

                $lev = levenshtein($input, $word);

                // Cherche une correspondance exacte
                if ($lev == 0) {
                    $closest = $word;
                    $shortest = 0;
                    break;
                }


                if ($lev <= $shortest || $shortest < 0) {
                    $closest = $word;
                    $shortest = $lev;
                }
            }


            if ($closest !== null) {
                $inputLength = strlen($input);
                $closestLength = strlen($closest);


                if ($inputLength > 0 && $closestLength > 0) {
                    $similarityLevenshtein = (1 - $shortest / max($inputLength, $closestLength)) * 100;
                    $totalSimilarity += $similarityLevenshtein;
                    $wordCount++;
                }
            }
        }


        return $wordCount > 0 ? $totalSimilarity / $wordCount : 0;
    }

    private function cosineSimilarity($vec1, $vec2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($vec1 as $index => $value) {
            if (isset($vec2[$index])) {
                $dotProduct += $value * $vec2[$index];
            }
            $magnitude1 += pow($value, 2);
        }

        foreach ($vec2 as $value) {
            $magnitude2 += pow($value, 2);
        }

        return $dotProduct / (sqrt($magnitude1) * sqrt($magnitude2));
    }

   



    private function normalizeText($text)
    {

        $text = preg_replace('/[^\w\s]/u', '', $text);

        return $text;
    }
}
