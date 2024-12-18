<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightedText extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'highlighted_text', 'average_similarity'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
