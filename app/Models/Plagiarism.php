<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plagiarism extends Model
{
    use HasFactory;

    protected $fillable = ['segment', 'similarity', 'url', 'document_id'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
