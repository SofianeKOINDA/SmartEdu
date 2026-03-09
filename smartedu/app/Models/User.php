<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'photo_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'utilisateur_id');
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class, 'utilisateur_id');
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class, 'utilisateur_id');
    }
}
