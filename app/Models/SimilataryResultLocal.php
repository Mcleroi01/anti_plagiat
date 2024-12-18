<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimilataryResultLocal extends Model
{
    /** @use HasFactory<\Database\Factories\SimilataryResultLocalFactory> */
    use HasFactory;

    protected $fillable = ['document_id', 'search_phrase', 'similarity_percentage', 'page_number', 'best_match'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
