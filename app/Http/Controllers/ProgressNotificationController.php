<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Log;
use App\Models\ProgressNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProgressNotificationRequest;
use App\Http\Requests\UpdateProgressNotificationRequest;

class ProgressNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $user = Auth::user();
            $document = Document::where('user_id', $user->id)->first();
            if (!$document) {
                return response()->json(['error' => 'Document not found'], 404);
            }

            $notifications = ProgressNotification::where('document_id', $document->id)
            ->where('status', 'Terminé') 
            ->with('document') 
            ->latest() 
            ->get();

           
            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Notification fetch error: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching notifications'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgressNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgressNotification $progressNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgressNotification $progressNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgressNotificationRequest $request, ProgressNotification $progressNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgressNotification $progressNotification)
    {
        //
    }
}
