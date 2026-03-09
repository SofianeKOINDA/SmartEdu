<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'etudiant_matricule',
        'montant',
        'date',
        'statut',
        'methode',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'date'    => 'date',
            'montant' => 'decimal:2',
        ];
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_matricule', 'matricule');
    }
}
