<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Document;
use App\Models\SearchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function create()
    {
        return view('documents.create');
    }
    public function upload(Request $request)
    {
        try {

            $request->validate([
                'document' => 'required|mimes:pdf,doc,docx|max:10120',
            ], [
                'document.required' => 'Veuillez sélectionner un document à télécharger.',
                'document.mimes' => 'Le document doit être au format PDF, DOC ou DOCX.',
                'document.max' => 'La taille maximale du document est de 10 Mo.',
            ]);

            Log::info('Validation passée avec succès.');

            $user = auth()->user();
            $credit = Credit::where('user_id', $user->id)->first();


            if (!$credit || $credit->documents_uploaded >= $credit->monthly_limit) {
                return redirect()->back()->with('error', 'Limite de documents atteinte pour ce mois.');
            }


            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/' . $user->id, $fileName, 'public'); // Stockage dans un sous-dossier utilisateur


            $document = new Document();
            $document->filename = $file->getClientOriginalName();
            $document->path = $filePath;
            $document->user_id = $user->id;
            $document->save();


            $plagiat = new PlagiarismController();
            $result = $plagiat->detect($document);
            $response = json_decode($result->getContent(), true);

            // Extraction des résultats
            $averageSimilarity = $response['average_similarity'] ?? 0;
            $results = $response['results'] ?? [];
            $highlighted_text = $response['highlighted_text'] ?? '';
            


            $credit->increment('documents_uploaded');


            return view('documents.create')
                ->with('averageSimilarity', $averageSimilarity)
                ->with('results', $results)
                ->with('text', $highlighted_text);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error("Erreur lors du téléchargement du document : {$e->getMessage()}");
            return redirect()->back()->with('error', "Erreur lors du téléchargement du document. Veuillez réessayer.");
        }
    }


    public function show(Document $document)
    {

        $searchResults = $document->searchResults;

        $singleResult = $document->searchResults->first();

        $averageSimilarity = $singleResult->avg('similarity_calculated');

        return view('documents.show', compact('document', 'searchResults', 'averageSimilarity'));
    }


    public function index()
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = auth()->user();

        // Récupérer les documents appartenant à cet utilisateur
        $documents = Document::where('user_id', $user->id)->get();

        return view('documents.index', compact('documents'));
    }





    public function showResults(Request $request)
    {
        // Récupérer les IDs depuis la requête
        $resultIds = $request->input('id'); // Si vous passez un tableau d'IDs via la route

        // Vérifiez si $resultIds est un tableau
        if (is_array($resultIds)) {
            // Récupérer les résultats correspondants
            $searchResults = SearchResult::whereIn('id', $resultIds)->get();
        } else {
            // Si ce n'est pas un tableau, récupérez un seul résultat
            $searchResults = SearchResult::where('id', $resultIds)->get();
        }

        // Passer les résultats à la vue
        return view('documents.results', compact('searchResults'));
    }
}
