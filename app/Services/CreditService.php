<?php

namespace App\Services;

use App\Models\Credit;

class CreditService
{
    public static function canUploadMoreDocuments($userId)
    {
        $credit = Credit::where('user_id', $userId)->first();
        return $credit && $credit->documents_uploaded < $credit->monthly_limit;
    }

    public static function incrementDocumentCount($userId)
    {
        $credit = Credit::where('user_id', $userId)->first();
        if ($credit) {
            $credit->increment('documents_uploaded');
        }
    }
}
