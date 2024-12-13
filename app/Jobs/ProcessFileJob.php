<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\ProgressNotification;
use App\Http\Controllers\PlagiarismController;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle()
    {
        try {
            // Créer une notification de progression initiale
            $notification = ProgressNotification::create([
                'document_id' => $this->document->id,
                'status' => 'En cours',
                'progress' => 0,
            ]);

            $this->updateProgress($notification, 25);
            $this->detectPlagiarismApiSearch();
            $this->updateProgress($notification, 50);
            $this->detectPlagiarismLocal();
            $this->updateProgress($notification, 100);
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    protected function updateProgress($notification, $progress)
    {
        $notification->update(['progress' => $progress]);
    }

    protected function detectPlagiarismApiSearch()
    {
        $plagiarismController = new PlagiarismController();
        $plagiarismController->detectApiSearch($this->document);
    }

    protected function detectPlagiarismLocal()
    {
        $plagiarismController = new PlagiarismController();
        $plagiarismController->detectLocal($this->document);
    }

    protected function handleError(\Exception $e)
    {
        // Enregistrer l'erreur dans la base de données et dans les logs
        ProgressNotification::create([
            'document_id' => $this->document->id,
            'status' => 'Erreur',
            'progress' => 0,
            'error_message' => $e->getMessage(),
        ]);
        Log::error("Error processing file: {$e->getMessage()}");
    }
}
