<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Document;
use App\Jobs\ProcessFileJob;
use App\Models\SearchResult;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\ProgressNotification;
use Illuminate\Support\Facades\Auth;
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

            $user = Auth::user();
            $credit = Credit::where('user_id', $user->id)->first();

            if (!$credit || $credit->documents_uploaded >= $credit->monthly_limit) {
                return redirect()->back()->with('error', 'Limite de documents atteinte pour ce mois.');
            }

            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/' . $user->id, $fileName, 'public');

            $document = new Document();
            $document->filename = $file->getClientOriginalName();
            $document->path = $filePath;
            $document->user_id = $user->id;
            $document->save();

            // Déclenche le job
            ProcessFileJob::dispatch($document);

            return response()->json(['success' => true, 'message' => 'Fichier téléchargé avec succès.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error("Erreur lors du téléchargement du document : {$e->getMessage()}");
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



    public function show(Document $document)
    {

        $searchResults = $document->searchResults;

        $singleResult = $document->searchResults->first();

        $averageSimilarity = $singleResult->avg('similarity_calculated');

        return view('documents.show', compact('document', 'searchResults', 'averageSimilarity'));
    }

    public function checkBatchProgress($documentId)
    {
        $progress = ProgressNotification::where('document_id', $documentId)->value('progress');
        return response()->json(['progress' => $progress]);
    }



    public function index()
    {
        
        $user = Auth::user();

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


    public function generatePlagiarismReport($documentId)
    {

        $document = Document::findOrFail($documentId);

        $searchResults = $document->searchResults;

        $singleResult = $document->searchResults->first();

        $averageSimilarity = $singleResult->avg('similarity_calculated');


        $pdf = Pdf::loadView('pdf.plagiarism_report', compact('document', 'searchResults', 'averageSimilarity'));


        return $pdf->download('attestation_analyse_' . $document->id . '.pdf');
    }
}
