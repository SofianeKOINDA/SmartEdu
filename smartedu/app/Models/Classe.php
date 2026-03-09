<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire',
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'classe_id');
    }

    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'classe_cours', 'classe_id', 'cours_id');
    }
}
