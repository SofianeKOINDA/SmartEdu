<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'filiere_id',
        'annee_scolaire_id',
        'nom',
        'niveau',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
