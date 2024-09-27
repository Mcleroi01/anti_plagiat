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

        $resultIds = $plagiat->detect($document);


        return redirect()->route('document.results', ['id' => $resultIds[0]]);
    }



    public function show(Document $document)
    {

        return view('documents.show', compact('document'));
    }

    public function index (){
        $documents = Document::all();
        return view('documents.index',compact('documents'));
    }



    public function showResults(SearchResult $search)
    {
        $searchResults = SearchResult::whereIn('id', $search)->get();
        return view('documents.results', compact('searchResults'));
    }
}
