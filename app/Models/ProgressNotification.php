<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressNotification extends Model
{
    /** @use HasFactory<\Database\Factories\ProgressNotificationFactory> */
    use HasFactory;

    protected $fillable = ['document_id', 'status', 'progress'];


    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
