<?php

namespace App\Http\Controllers;

use TypeError;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use App\Models\Document;
use App\Models\SearchResult;
use Smalot\PdfParser\Parser;
use App\Models\DocumentsLocal;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\Element\Text;
use App\Models\SimilataryResultLocal;
use App\Models\HighlightedText;

class PlagiarismController extends Controller
{
    public function detectApiSearch(Document $document)
    {
        $text = $this->extractTextFromDocument($document);
        $documentId = $document->id;
        try {
            Log::info("Début du traitement pour le fichier : ");
            if (empty($text)) {
                Log::error("Impossible d'extraire le texte du fichier.");
                return response()->json(['error' => 'Aucun texte détecté dans le fichier.'], 400);
            }


            $text = $this->cleanText($text);



            $processedData = $this->processSegments($text, $documentId);
            $highlightedText = $this->highlightPlagiarizedText($processedData['text'], $processedData['results']);
            $this->storeHighlightedText($documentId, $highlightedText, $processedData['average_similarity']);

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

        foreach ($segments as $segment) {
            if (is_array($segment) && isset($segment['text'])) {
                $segmentText = trim($segment['text']);

                // Ignorez les segments trop courts ou vides
                if (empty($segmentText) || strlen($segmentText) < 10) {
                    Log::info("Segment ignoré (trop court ou vide) : " . var_export($segment, true));
                    continue;
                }

                // Découpez le segment si nécessaire
                $splitSegments = $this->splitSegment($segmentText, 300);

                foreach ($splitSegments as $splitSegment) {
                    Log::info("Segment à rechercher : " . $splitSegment); // Ajout d'un log pour le segment à rechercher

                    $searchResults = $this->searchSegment($splitSegment);

                    if (!empty($searchResults['organic'])) {
                        $segmentNormalized = strtolower(trim($splitSegment));
                        $snippetNormalized = strtolower(trim($searchResults['organic'][0]['snippet']));
                        // Calculer la similarité
                        $similarity = $this->calculateHybridSimilarity($segmentNormalized, $snippetNormalized);

                        if ($similarity >= 10) {
                            $totalSimilarity += $similarity;
                            $totalSegments++;

                            // Ajouter le résultat au tableau à stocker
                            $resultsToStore[] = [
                                'document_id' => $documentId,
                                'search_phrase' => $splitSegment,
                                'result_snippet' => $searchResults['organic'][0]['snippet'],
                                'similarity_calculated' => $similarity,
                                'result_link' => $searchResults['organic'][0]['link'],
                                'page_number' => $segment['page'] ?? 0,
                            ];
                        }
                    } else {
                        Log::warning("Aucun résultat trouvé pour le segment : " . $splitSegment);
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
        if (empty(trim($segment))) {
            Log::error('Segment vide ignoré.');
            return null;
        }

        $client = new Client();
        $headers = [
            'X-API-KEY' => 'c9af7b520b092b3bce8fc4d9a4de9a9589af3fe2',
            'Content-Type' => 'application/json',
        ];

        $body = json_encode(['q' => $segment, 'hl' => 'fr']);

        try {
            $response = $client->post('https://google.serper.dev/search', [
                'headers' => $headers,
                'body' => $body,
                'verify' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Erreur HTTP : ' . $response->getStatusCode());
            }

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche : ' . $e->getMessage());
            return null;
        }
    }



    public function detectLocal(Document $document)
    {
        try {
            // Extraire le texte du document
            $text = $this->extractTextFromDocument($document);
            $documentId = $document->id;

            Log::info("debuts de traitement local ");

            if (empty($text)) {
                return response()->json(['error' => 'Aucun texte détecté dans le fichier.'], 400);
            }

            // Segmentation et nettoyage
            $segments = $this->createSegments($text);
            $localDocuments = DocumentsLocal::all();
            $localSegments = $this->prepareLocalSegments($localDocuments);

            Log::info("Nombre de segments analysés : " . count($segments));
            $results = $this->processLocalSegments($segments, $localSegments, $documentId);
            $highlightedText = $this->highlightPlagiarizedText(
                $text,
                $results['results']
            );
            $this->storeHighlightedText($documentId, $highlightedText, $results['average_similarity']);

            return $results;
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'analyse locale : " . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'analyse locale.'], 500);
        }
    }

    private function processLocalSegments($segments, $localSegments, $documentId)
    {
        try {
            $totalSimilarity = 0;
            $validSegments = 0;
            $results = [];

            foreach ($segments as $segment) {
                if (is_array($segment) && isset($segment['text'])) {
                    $segmentText = trim($segment['text']);

                    // Vérifiez si le segment est vide ou trop court
                    if (empty($segmentText) || strlen($segmentText) < 10) {
                        continue;
                    }

                    $splitSegments = $this->splitSegment($segmentText, 2048);
                    $joinedSegment = implode(' ', $splitSegments);

                    
                    if (empty($joinedSegment)) {
                        Log::warning("Le segment joint est vide, impossible de trouver une correspondance.");
                        continue;
                    }

                    $bestMatch = $this->findBestMatch($joinedSegment, $localSegments);

                    // Only process segments with similarity > 70
                    if (!empty($joinedSegment) && $bestMatch['similarity'] > 70) {
                        $totalSimilarity += $bestMatch['similarity'];
                        $validSegments++;

                        $result = [
                            'document_id' => $documentId,
                            'search_phrase' => $joinedSegment,
                            'best_match' => $bestMatch['match'],
                            'similarity_percentage' => $bestMatch['similarity'],
                            'page_number' => $segment['page'] ?? 0,
                        ];

                        $this->storeResultIfNotExists($result);
                        $results[] = $result;
                    }
                }
            }

            $averageSimilarity = $validSegments > 0 ? $totalSimilarity / $validSegments : 0;

            return [
                'success' => true,
                'average_similarity' => $averageSimilarity,
                'results' => $results,
            ];
        } catch (\Exception $th) {
            Log::error('Error processing local segments: ' . $th->getMessage());
            throw $th;
        }
    }


    private function storeResultIfNotExists($result)
    {
        try {
            Log::info("Tentative de stockage du résultat", $result);

            $existingResults = SimilataryResultLocal::where('document_id', $result['document_id'])
                ->pluck('search_phrase')->toArray();

            if (!in_array($result['search_phrase'], $existingResults)) {
                SimilataryResultLocal::create($result);
            }
        } catch (\Exception $th) {
            Log::error('Error storing result: ' . $th->getMessage());
        }
    }


    private function findBestMatch($joinedSegment, $localSegments)
    {
        $highestSimilarity = 0;
        $bestMatch = null;

        foreach ($localSegments as $localSegment) {
            $similarity = $this->calculateHybridSimilarity($joinedSegment, $localSegment);

            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
                $bestMatch = implode(', ', $localSegment);
            }
        }

        return ['similarity' => $highestSimilarity, 'match' => $bestMatch];
    }

    private function prepareLocalSegments($localDocuments)
    {
        return collect($localDocuments)
            ->flatMap(function ($doc) {
                return $this->createSegments($doc->content);
            })
            ->filter(function ($segment) {
                return is_array($segment) && isset($segment['text']) && strlen(trim($segment['text'])) >= 10;
            })
            ->toArray();
    }

    private function isResultValid($result)
    {
        $requiredKeys = ['document_id', 'search_phrase', 'best_match', 'similarity_percentage', 'page_number', 'highlighted_text'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $result)) {
                return false;
            }
        }
        return true;
    }

    protected function storeHighlightedText($documentId, $highlightedText, $averageSimilarity)
    {
        try {
            // Enregistrer les informations dans la base de données
            HighlightedText::create([
                'document_id' => $documentId,
                'highlighted_text' => $highlightedText,
                'average_similarity' => $averageSimilarity,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'enregistrement du HighlightedText : " . $e->getMessage());
        }
    }
    private function extractTextFromDocument($document): bool|string
    {
        $path = public_path('storage/' . $document->path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $text = '';

        try {
            switch ($extension) {
                case 'pdf':
                    try {
                        $parser = new Parser();
                        $pdf = $parser->parseFile($path);
                        $text = $pdf->getText();
                        break;
                    } catch (\Exception $th) {
                        Log::error("Erreur lors de la lecture du PDF pour le document ID " . $document->id . ": " . $th->getMessage());
                    }
                   

                case 'docx':
                    try {
                        $phpWord = IOFactory::load($path);
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                if ($element instanceof Text) {
                                    $text .= $element->getText() . ' ';
                                }
                            }
                        }
                        break;
                    } catch (\Exception $th) {
                        Log::error("Erreur lors de la lecture du DOCX pour le document ID " . $document->id . ": " . $th->getMessage());
                    }
                    

                case 'txt':
                    try {
                        $text = file_get_contents($path);
                        break;
                    } catch (\Exception $th) {
                        Log::error("Erreur lors de la lecture du DOCX pour le document ID " . $document->id . ": " . $th->getMessage());
                    }
                    
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'extraction du texte pour le document ID " . $document->id . ": " . $e->getMessage());
        }

        return $text;
    }

    private function cleanText($text)
    {
        $text = preg_replace([
            '/\b\d+\.\s*/', // Numéros de liste
            '/\b(?:[IVXLCDM]+\.)\s*/i', // Numéros romains
            '/\b(année académique|préambule|liste des tableaux|introduction|annexe|bibliographie)\b/i', // Phrases non pertinentes
            '/[^a-zA-Z0-9\sàéèêëùûüç]/u', // Supprime caractères non pertinents
            '/\s+/', // Normalisation des espaces multiples
        ], ' ', $text);
        return trim($text);
    }

    private function createSegments(string $text, int $wordsPerSegment = 300, int $maxSegmentLength = 500): array
    {
        $words = explode(' ', $text);
        $segments = [];
        $currentSegment = [];
        $currentWordCount = 0;

        foreach ($words as $word) {
            $currentSegment[] = $word;
            $currentWordCount++;

            if ($currentWordCount >= $wordsPerSegment) {
                $segmentText = implode(' ', $currentSegment);
                if (strlen($segmentText) > $maxSegmentLength) {
                    $segmentText = wordwrap($segmentText, $maxSegmentLength, "\n", true);
                    foreach (explode("\n", $segmentText) as $chunk) {
                        $segments[] = ['text' => trim($chunk)];
                    }
                } else {
                    $segments[] = ['text' => trim($segmentText)];
                }
                $currentSegment = [];
                $currentWordCount = 0;
            }
        }

        if (!empty($currentSegment)) {
            $segmentText = implode(' ', $currentSegment);
            $segments[] = ['text' => trim($segmentText)];
        }

        return $segments;
    }

    private function splitSegment($segment, $maxLength = 200)
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
            $text = preg_replace("/\b($searchPhrase)\b/", '<mark class="highlight transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 ...">$1</mark>', $text);
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
