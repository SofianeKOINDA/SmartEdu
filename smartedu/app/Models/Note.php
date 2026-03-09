<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'etudiant_id',
        'evaluation_id',
        'valeur',
        'commentaire',
        'semestre',
    ];

    protected function casts(): array
    {
        return [
            'valeur' => 'decimal:2',
        ];
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }
}
