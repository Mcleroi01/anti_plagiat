<?php

namespace App\Http\Controllers;

use TypeError;
use GuzzleHttp\Client;
use App\Models\Document;
use App\Models\Plagiarism;
use App\Models\SearchResult;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use App\Models\SimilataryResultLocal;
use App\Http\Requests\StorePlagiarismRequest;
use App\Http\Requests\UpdatePlagiarismRequest;
use App\Models\DocumentsLocal;

class PlagiarismController extends Controller
{
    public function detectApiSearch(Document $document)
    {
        $text = $this->extractTextFromDocument($document);
        $documentId = $document->id;
        try {
            Log::info("Début du traitement pour le fichier : " . $text);
            if (empty($text)) {
                Log::error("Impossible d'extraire le texte du fichier.");
                return response()->json(['error' => 'Aucun texte détecté dans le fichier.'], 400);
            }

            Log::info("Texte extrait, longueur : " . strlen($text));
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
    private function processSegments($text, $documentId)
    {
        $segments = $this->createSegments($text);

        Log::info("Nombre de segments créés : " . count($segments));

        $totalSimilarity = 0;
        $totalSegments = 0;
        $resultsToStore = [];

        foreach ($segments as  $segment) {

            if (is_array($segment) && isset($segment['text'])) {
                $segmentText = $segment['text'];

                Log::info("Traitement du segment : " . substr($segmentText, 0, 50) . "...");

                // Ignorez les segments trop courts
                if (strlen(trim($segmentText)) < 10) {
                    Log::info("Segment trop court, ignoré.");
                    continue;
                }

                // Découpez le segment si nécessaire
                $splitSegments = $this->splitSegment(trim($segmentText), 300);

                foreach ($splitSegments as $splitSegment) {
                    Log::info("Recherche de similarité pour le segment : " . substr($splitSegment, 0, 50) . "...");

                    // Rechercher les résultats pour le segment
                    $searchResults = $this->searchSegment($splitSegment);

                    if (!empty($searchResults['organic'])) {
                        $segmentNormalized = strtolower(trim($splitSegment));
                        $snippetNormalized = strtolower(trim($searchResults['organic'][0]['snippet']));
                        // Calculer la similarité
                        $similarity = $this->calculateHybridSimilarity($segmentNormalized, $snippetNormalized);
                        Log::info("Similarité calculée : " . $similarity . "%");

                        if ($similarity >= 10) {
                            $totalSimilarity += $similarity;
                            $totalSegments++;
                            Log::info("Segment retenu avec une similarité de " . $similarity . "%");

                            // Ajouter le résultat au tableau à stocker
                            $resultsToStore[] = [
                                'document_id' => $documentId,
                                'search_phrase' => $splitSegment,
                                'result_snippet' => $searchResults['organic'][0]['snippet'],
                                'similarity_calculated' => $similarity,
                                'result_link' => $searchResults['organic'][0]['link'],
                                'page_number' => $segment['page'] ?? 0, // Utiliser la page si disponible
                            ];
                        } else {
                            Log::info("Similarité inférieure à 10%, segment ignoré.");
                        }
                    } else {
                        Log::info("Aucun résultat trouvé pour ce segment.");
                    }
                }
            } else {
                Log::warning("Le segment n'est pas valide : " . var_export($segment, true));
            }
        }


        $averageSimilarity = $totalSegments > 0 ? $totalSimilarity / $totalSegments : 0;

        foreach ($resultsToStore as &$result) {
            $result['global_similarity_calculated'] = $averageSimilarity;
        }

        foreach ($resultsToStore as $result) {
            SearchResult::create($result);
        }

        return [
            'success' => true,
            'message' => 'Traitement terminé',
            'average_similarity' => $averageSimilarity,
            'results' => $resultsToStore,
            'text' => $text,
        ];
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

    public function detectLocal(Document $document)
    {
        try {
            // Extraire le texte du document
            $text = $this->extractTextFromDocument($document);
            $documentId = $document->id;

            if (empty($text)) {
                return response()->json(['error' => 'Aucun texte détecté dans le fichier.'], 400);
            }

            // Segmentation et nettoyage
            $segments = $this->createSegments($text);
            $localDocuments = DocumentsLocal::all();
            $localSegments = $this->prepareLocalSegments($localDocuments);

            Log::info("Nombre de segments analysés : " . count($segments));
            $results = $this->processLocalSegments($segments, $localSegments, $documentId);

            return response()->json([
                'success' => true,
                'message' => 'Analyse locale terminée.',
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'analyse locale : " . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'analyse locale.'], 500);
        }
    }

    private function processLocalSegments($segments, $localSegments, $documentId)
    {
        $results = [];

        foreach ($segments as $segment) {
            // Vérifiez si le segment est bien une chaîne ou un tableau contenant 'text'
            if (is_array($segment) && isset($segment['text'])) {
                $segmentText = $segment['text'];
            } elseif (is_string($segment)) {
                $segmentText = $segment;
            } else {
                continue; // Ignorer les segments invalides
            }

            // Ignorer les segments trop courts
            if (strlen(trim($segmentText)) < 10) {
                continue;
            }

        
            $splitSegments = $this->splitSegment(trim($segmentText), 300);

            
            $joinedSegment = implode(' ', $splitSegments);

            $highestSimilarity = 0;
            $bestMatch = null;

            foreach ($localSegments as $localSegment) {
                $similarity = $this->calculateHybridSimilarity($joinedSegment, $localSegment);

                if ($similarity > $highestSimilarity) {
                    $highestSimilarity = $similarity;
                    $bestMatch = implode(', ', $localSegment);
                }
            }

            if ($highestSimilarity > 70) { // Seuil de similarité
                $result = [
                    'document_id' => $documentId,
                    'search_phrase' => $joinedSegment, // Chaîne combinée
                    'best_match' => $bestMatch,
                    'similarity_percentage' => $highestSimilarity,
                    'page_number' =>  $segment['page']?? 0, // Utiliser la page si disponible
                ];

                $this->storeResultIfNotExists($result);
                $results[] = $result;
            }
        }

        return $results;
    }


    private function storeResultIfNotExists($result)
    {
        if (!SimilataryResultLocal::where('document_id', $result['document_id'])
            ->where('search_phrase', $result['search_phrase'])
            ->exists()) {
            SimilataryResultLocal::create($result);
        }
    }

    private function prepareLocalSegments($localDocuments)
    {
        $localSegments = [];

        foreach ($localDocuments as $localDocument) {
            $segments = $this->createSegments($localDocument->content);
            $localSegments = array_merge($localSegments, $segments);
        }

        return $localSegments;
    }


    private function searchLocalSegment($segment, $localSegments)
    {
        $highestSimilarity = 0;

        foreach ($localSegments as $localText) {
            // Ensure $localText is a string
            if (is_array($localText)) {
                $localText = $localText['content'] ?? ''; // Adjust key name based on your data structure
            }

            $cleanedLocalText = $this->cleanText($localText);

            if (!is_string($cleanedLocalText) || strlen($cleanedLocalText) < 1) {
                continue; // Skip invalid or empty cleaned texts
            }

            $similarity = $this->calculateHybridSimilarity($segment, $cleanedLocalText);

            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
            }
        }

        return $highestSimilarity;
    }

    private function extractTextFromDocument($document): bool|string
    {
        $path = public_path('storage/' . $document->path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $text = '';

        try {
            switch ($extension) {
                case 'pdf':
                    $parser = new Parser();
                    $pdf = $parser->parseFile($path);
                    $text = $pdf->getText();
                    break;

                case 'docx':
                    $phpWord = IOFactory::load($path);
                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $element->getText() . ' ';
                            }
                        }
                    }
                    break;

                case 'txt':
                    $text = file_get_contents($path);
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'extraction du texte pour le document ID " . $document->id . ": " . $e->getMessage());
        }

        return $text;
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

    private function createSegments(string $text, int $wordsPerSegment = 300, int $wordsPerPage = 300): array
    {
        $words = explode(' ', $text);
        $segments = [];
        $currentSegment = [];
        $currentPage = 1;
        $currentWordCount = 0;

        foreach ($words as $word) {
            $currentSegment[] = $word;
            $currentWordCount++;

            if (count($currentSegment) >= $wordsPerSegment) {
                $segments[] = ['text' => implode(' ', $currentSegment), 'page' => $currentPage];
                $currentSegment = [];
            }

            if ($currentWordCount >= $wordsPerPage) {
                $currentPage++;
                $currentWordCount = 0;
            }
        }

        if (!empty($currentSegment)) {
            $segments[] = ['text' => implode(' ', $currentSegment), 'page' => $currentPage];
        }

        return $segments;
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
        foreach ($plagiarizedSegments as $segment) {
            $searchPhrase = preg_quote($segment['search_phrase'], '/');
            $text = preg_replace("/\b($searchPhrase)\b/", '<span class="highlight">$1</span>', $text);
        }

        return $text;
    }

    private function calculateHybridSimilarity($text1, $text2, $threshold = 70)
    {
        // Normalize and ensure inputs are strings
        $normalize = function ($text) {
            if (is_array($text)) {
                $text = implode(' ', $text);
            }
            return (string)$this->normalizeText(trim($text));
        };

        $text1 = $normalize($text1);
        $text2 = $normalize($text2);

        // Handle empty cases
        if (empty($text1) && empty($text2)) {
            return 100;
        }
        if (empty($text1) || empty($text2)) {
            return 0;
        }

        // Step 1: Calculate similarity using `similar_text`
        if (!is_string($text1) || !is_string($text2)) {
            throw new TypeError('Arguments must be of type string');
        }

        $similarityPercentage = 0;
        similar_text($text1, $text2, $similarityPercentage);

        if ($similarityPercentage >= $threshold) {
            return $similarityPercentage;
        }

        // Step 2: Fallback to word-level similarity using Levenshtein
        $words1 = explode(' ', $text1);
        $words2 = array_unique(explode(' ', $text2)); // Unique words in $text2

        $totalSimilarity = 0;
        $wordCount = 0;

        foreach ($words1 as $word1) {
            $bestMatch = null;
            $lowestDistance = PHP_INT_MAX;

            foreach ($words2 as $word2) {
                $lev = levenshtein($word1, $word2);
                if ($lev < $lowestDistance) {
                    $lowestDistance = $lev;
                    $bestMatch = $word2;
                }
            }

            if ($bestMatch !== null) {
                $inputLength = strlen($word1);
                $matchLength = strlen($bestMatch);

                if ($inputLength > 0 && $matchLength > 0) {
                    $similarity = (1 - $lowestDistance / max($inputLength, $matchLength)) * 100;
                    $totalSimilarity += $similarity;
                    $wordCount++;
                }
            }
        }

        // Step 3: Return the average similarity
        return $wordCount > 0 ? $totalSimilarity / $wordCount : 0;
    }
    private function normalizeText($text)
    {
        $text = preg_replace('/[^\w\s]/u', '', $text);
        return $text;
    }
}
