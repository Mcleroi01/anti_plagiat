<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProgressNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\PlagiarismController;

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
            if (!$this->document) {
                throw new \Exception('Document non valide.');
            }

            $notification = ProgressNotification::create([
                'document_id' => $this->document->id,
                'status' => 'En cours',
                'progress' => 0,
            ]);

            $notification->update(['progress' => 25]);
            $plagiarismController = new PlagiarismController();
            $resultLocales = $plagiarismController->detectLocal($this->document);
            Log::info($resultLocales);

            if ($resultLocales >= 50.0) {
                $notification->update([
                    'progress' => 100,
                    'status' => 'Terminé',
                ]);

                return; // Arrête le processus si le résultat local est suffisant
            }

            $notification->update(['progress' => 50]);
            $resultApi = $plagiarismController->detectApiSearch($this->document);

            $notification->update([
                'progress' => 100,
                'status' => 'Terminé',
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur dans le traitement du fichier : {$e->getMessage()}");

            ProgressNotification::create([
                'document_id' => $this->document->id ?? null,
                'status' => 'Erreur',
                'progress' => 0,
            ]);
        }
    }
}
