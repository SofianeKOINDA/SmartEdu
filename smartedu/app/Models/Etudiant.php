<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiants';

    protected $fillable = [
        'user_id',
        'matricule',
        'date_naissance',
        'classe_id',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'etudiant_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'etudiant_id');
    }
}
