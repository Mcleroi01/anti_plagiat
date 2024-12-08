<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Credit;
use App\Models\SearchResult;
use Illuminate\Http\Request;

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
                'document' => 'required|mimes:pdf,doc,docx|max:2048',
            ]);

            $user = auth()->user();
            $credit = Credit::where('user_id', $user->id)->first();

            if (!$credit || $credit->documents_uploaded >= $credit->monthly_limit) {
                return redirect()->back()->with('error', 'Limite de documents atteinte pour ce mois.');
            }

            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $document = new Document();
            $document->filename = $file->getClientOriginalName();
            $document->path = $filePath;
            $document->user_id = $user->id;
            $document->save();

            $plagiat = new PlagiarismController();
            $result = $plagiat->detect($document);
            $response = json_decode($result->getContent(), true);

            $averageSimilarity = $response['average_similarity'];
            $results = $response['results'];
            $text = $response['text'];

            $credit->increment('documents_uploaded');

            return view('documents.create')
                ->with('averageSimilarity', $averageSimilarity)
                ->with('results', $results)
                ->with('text', $text);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $th) {
            return redirect()->back()->with('error', "Erreur lors du téléchargement du document: $th");
        }
    }






    public function show(Document $document)
    {

        $searchResults = $document->searchResults;
        $averageSimilarity = $searchResults->avg('similarity_calculated') ?? 0; // Valeur par défaut si aucune donnée


        // Retourner la vue avec le document et les résultats de recherche
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
