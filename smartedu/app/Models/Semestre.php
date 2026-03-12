<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'annee_scolaire_id',
        'nom',
        'numero',
        'date_debut',
        'date_fin',
        'actif',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'actif' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function ues()
    {
        return $this->hasMany(UE::class);
    }

    public function deliberations()
    {
        return $this->hasMany(Deliberation::class);
    }
}
