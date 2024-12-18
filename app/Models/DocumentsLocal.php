<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsLocal extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentsLocalFactory> */
    use HasFactory;
    protected $fillable = ['title', 'content'];

    public function similarityResults()
    {
        return $this->hasMany(SearchResult::class);
    }

    public function progressNotifications()
    {
        return $this->hasMany(ProgressNotification::class);
    }
}
