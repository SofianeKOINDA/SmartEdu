<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $table = 'cours';

    protected $fillable = [
        'titre',
        'enseignant_id',
        'type',
        'description',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_cours', 'cours_id', 'classe_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'cours_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'cours_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'cours_id');
    }
}
