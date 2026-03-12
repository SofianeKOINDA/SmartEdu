<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'nom',
        'slug',
        'email',
        'telephone',
        'adresse',
        'logo',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }

    public function facultes()
    {
        return $this->hasMany(Faculte::class);
    }

    public function anneesScolaires()
    {
        return $this->hasMany(AnneeScolaire::class);
    }

    public function tarifs()
    {
        return $this->hasMany(Tarif::class);
    }
}
