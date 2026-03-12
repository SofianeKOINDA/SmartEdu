<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix_mensuel',
        'max_etudiants',
        'max_enseignants',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'prix_mensuel' => 'decimal:2',
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
}
