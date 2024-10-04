<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    // Définir les attributs qui peuvent être remplis en masse
    protected $fillable = [
        'user_id',
        'monthly_limit',
        'documents_uploaded',
    ];

    // Définir la relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifie si l'utilisateur peut encore uploader des documents
     *
     * @return bool
     */
    public function canUpload()
    {
        return $this->documents_uploaded < $this->monthly_limit;
    }

    /**
     * Incrémente le nombre de documents uploadés
     *
     * @return void
     */
    public function incrementDocumentsUploaded()
    {
        $this->increment('documents_uploaded');
    }

    /**
     * Réinitialise le compteur de documents uploadés
     *
     * @return void
     */
    public function resetDocumentsUploaded()
    {
        $this->documents_uploaded = 0;
        $this->save();
    }
}
