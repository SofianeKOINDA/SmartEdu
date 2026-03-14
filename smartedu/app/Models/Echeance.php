<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'echeances';

    protected $fillable = [
        'tenant_id',
        'etudiant_id',
        'tarif_id',
        'numero_mois',
        'montant',
        'date_limite',
        'statut',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_limite' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function estPayee(): bool
    {
        return $this->statut === 'paye';
    }

    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }
}
