<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\HighlightedText;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'path','email','user_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->_id = (string) Str::uuid();
        });
    }

    public function searchResults():HasMany
    {
        return $this->hasMany(SearchResult::class);
    }

    public function similataryResultLocal(): HasMany
    {
        return $this->hasMany(SimilataryResultLocal::class);
    }

    public function highlightedText(): HasOne
    {
        return $this->hasOne(HighlightedText::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
