<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'presences';

    protected $fillable = [
        'etudiant_id',
        'cours_id',
        'date',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}
