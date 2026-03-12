<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'ue_id',
        'enseignant_id',
        'intitule',
        'code',
        'coefficient',
        'volume_horaire',
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function ue()
    {
        return $this->belongsTo(UE::class, 'ue_id');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function inscriptionsPedagogiques()
    {
        return $this->hasMany(InscriptionPedagogique::class);
    }

    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'inscriptions_pedagogiques', 'cours_id', 'etudiant_id');
    }
}
