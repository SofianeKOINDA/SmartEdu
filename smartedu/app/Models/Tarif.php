<?php

namespace App\Models;

use App\Services\EcheanceService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'annee_scolaire_id',
        'montant_total',
        'nombre_echeances',
        'jour_limite',
        'cree_par',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(function (Tarif $tarif) {
            /** @var EcheanceService $service */
            $service = app(EcheanceService::class);
            $service->genererPourTousLesEtudiants($tarif);
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function creePar()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function echeances()
    {
        return $this->hasMany(Echeance::class);
    }
}
