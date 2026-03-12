<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'annees_scolaires';

    protected $fillable = [
        'tenant_id',
        'libelle',
        'date_debut',
        'date_fin',
        'courante',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'courante' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function tarifs()
    {
        return $this->hasMany(Tarif::class);
    }
}
