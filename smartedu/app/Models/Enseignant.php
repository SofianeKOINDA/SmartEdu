<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends User
{
    use HasFactory;

    protected $table = 'enseignants';

    protected $fillable = [
        'user_id',
        'specialite',
        'telephone',
        'matricule_enseignant',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'enseignant_matricule', 'matricule_enseignant');
    }
}
