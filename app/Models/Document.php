<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'path','email'];

    public function searchresult():HasMany
    {
        return $this->hasMany(SearchResult::class);
    }
}
