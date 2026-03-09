<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';

    protected $fillable = [
        'cours_id',
        'titre',
        'type',
        'description',
        'date_limite',
        'coefficient',
    ];

    protected function casts(): array
    {
        return [
            'date_limite' => 'datetime',
            'coefficient' => 'decimal:2',
        ];
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'evaluation_id');
    }
}
