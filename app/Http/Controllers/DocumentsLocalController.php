<?php

namespace App\Http\Controllers;

use App\Models\DocumentsLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentsLocalController extends Controller
{
    public function index(){
        $documents = DocumentsLocal::all();
        return view('documents_local.index', compact('documents'));
    }

    public function show($id){
        $document = DocumentsLocal::find($id);
        return view('documents_local.show', compact('document'));
    }

    public function create(){
        return view('documents_local.create');
    }
    public function upload(Request $request)
    {
        $request->validate(['document' => 'required|file|mimes:pdf,docx']);

        $file = $request->file('document');
        $extension = $file->getClientOriginalExtension();
        $content = '';

        if ($extension === 'pdf') {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $content = $pdf->getText();
        } elseif ($extension === 'docx') {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getPathname());
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    
                    if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                        $content .= $element->getText() . " ";
                    } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textElement) {
                           
                            if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $content .= $textElement->getText() . " ";
                            } elseif ($textElement instanceof \PhpOffice\PhpWord\Element\Link) {
                                $content .= $textElement->getText() . " "; 
                            } else {
                                Log::error(" ");
                            }
                        }
                    }

                    
                }
            }
        }

        DocumentsLocal::create([
            'title' => $file->getClientOriginalName(),
            'content' => $content,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }


}
