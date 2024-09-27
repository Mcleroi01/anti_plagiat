<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'search_phrase',
        'result_snippet',
        'similarity_calculated',
        'result_link',
        'global_similarity_calculated',
    ];


    public function document():BelongsTo
    {
        return $this->belongsTo(Document::class); 
    }
}
