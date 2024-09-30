<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
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

        $request->validate([
            'document' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);


        $file = $request->file('document');


        $fileName = time() . '_' . $file->getClientOriginalName();


        $filePath = $file->storeAs('documents', $fileName, 'public');


        $document = new Document();
        $document->filename = $file->getClientOriginalName();
        $document->path = $filePath;
        $document->save();


        $plagiat = new PlagiarismController;

        $result = $plagiat->detect($document);


        $response = json_decode($result->getContent(), true);

        // Accéder à 'average_similarity' et 'results'
        $averageSimilarity = $response['average_similarity'];
        $results = $response['results'];

        // Redirection vers la vue 'documents.create' avec les résultats
        return view('documents.create')
            ->with('averageSimilarity', $averageSimilarity)
            ->with('results', $results);
    }



    public function show(Document $document)
    {

        return view('documents.show', compact('document'));
    }

    public function index()
    {
        $documents = Document::all();
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
