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
        // Validation des données
        $request->validate([
            'document' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = auth()->user();
        $credit = Credit::where('user_id', $user->id)->first();

        // Vérifier si l'utilisateur a des crédits disponibles
        if (!$credit || $credit->documents_uploaded >= $credit->monthly_limit) {
            return redirect()->back()->with('error', 'Limite de documents atteinte pour ce mois.');
        }

        // Traiter le fichier téléchargé
        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        // Enregistrer le document dans la base de données
        $document = new Document();
        $document->filename = $file->getClientOriginalName();
        $document->path = $filePath;
        $document->user_id = $user->id;
        $document->save();



        // Détection de plagiat
        $plagiat = new PlagiarismController();
        $result = $plagiat->detect($document);
        $response = json_decode($result->getContent(), true);

        $averageSimilarity = $response['average_similarity'];
        $results = $response['results'];
        $text = $response['text'];

        // Incrémenter le compteur de documents uploadés
        $credit->increment('documents_uploaded');

        return view('documents.create')
            ->with('averageSimilarity', $averageSimilarity)
            ->with('results', $results)
            ->with('text', $text)
        ;
    }





    public function show(Document $document)
    {

        return view('documents.show', compact('document'));
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
