<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'tenant_id',
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

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'user_id');
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class, 'user_id');
    }
}
