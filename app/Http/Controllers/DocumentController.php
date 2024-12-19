<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Document;
use App\Jobs\ProcessFileJob;
use App\Models\SearchResult;
use Illuminate\Http\Request;
use App\Services\CreditService;
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

    public function index()
    {
        $user = Auth::user();
        $documents = Document::where('user_id', $user->id)->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }
  
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,doc,docx,txt|max:10120',
        ], [
            'document.required' => 'Veuillez sélectionner un document à télécharger.',
            'document.mimes' => 'Le document doit être au format PDF, DOC ou DOCX.',
            'document.max' => 'La taille maximale du document est de 10 Mo.',
        ]);

        $user = Auth::user();

        if (!CreditService::canUploadMoreDocuments($user->id)) {
            return response()->json(['success' => false, 'message' => 'Limite de documents atteinte pour ce mois.'], 403);
        }

        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $user->id, $fileName, 'public');

        $document = Document::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $filePath,
            'user_id' => $user->id,
        ]);

        CreditService::incrementDocumentCount($user->id);

        ProcessFileJob::dispatch($document);

        return response()->json([
            'success' => true,
            'document_id' => $document->id,
            'document_show' => $document->_id,
        ]);
    }

    public function show(Document $document)
    {
        $localResults = $document->similataryResultLocal;
        $apiResults = $document->searchResults;
        return view('documents.show', compact('document', 'localResults', 'apiResults'));
    }

    public function generatePDF(Document $document)
    {
        // Récupérer les résultats locaux et de l'API
        $localResults = $document->similataryResultLocal;
        $apiResults = $document->searchResults;

        // Vérifier si les données existent
        if (!$localResults && !$apiResults) {
            return redirect()->back()->with('error', 'Aucun résultat trouvé pour ce document.');
        }

        // Générer le fichier PDF avec les données
        $pdf = PDF::loadView('attestation.index', compact('localResults', 'apiResults', 'document'));

        // Télécharger le fichier PDF
        return $pdf->download('resultat-traitement.pdf');
    }




    public function checkBatchProgress($documentId)
    {
        $progress = ProgressNotification::where('document_id', $documentId)->value('progress');
        return response()->json([
            'progress' => $progress ?? 0,
        ]);
    }
        public function showResults(Request $request)
    {
        $resultIds = $request->input('id'); 

        if (is_array($resultIds)) {
            $searchResults = SearchResult::whereIn('id', $resultIds)->get();
        } else {
            $searchResults = SearchResult::where('id', $resultIds)->get();
        }
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