<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends User
{
    use HasFactory;

    protected $table = 'administrateurs';

    protected $fillable = [
        'user_id',
        'departement',
        'telephone',
        'matricule_administrateur',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
