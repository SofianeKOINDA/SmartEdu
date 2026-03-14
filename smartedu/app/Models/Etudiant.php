<?php

namespace App\Models;

use App\Services\EcheanceService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'promotion_id',
        'numero_etudiant',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        'actif',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'actif' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function (Etudiant $etudiant) {
            /** @var EcheanceService $service */
            $service = app(EcheanceService::class);
            $service->genererPourEtudiant($etudiant);
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function echeances()
    {
        return $this->hasMany(Echeance::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function deliberations()
    {
        return $this->hasMany(Deliberation::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function inscriptionsPedagogiques()
    {
        return $this->hasMany(InscriptionPedagogique::class);
    }

    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'inscriptions_pedagogiques', 'etudiant_id', 'cours_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
