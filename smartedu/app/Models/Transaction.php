<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'echeance_id',
        'etudiant_id',
        'reference',
        'montant',
        'statut',
        'paytech_token',
        'paytech_ref',
        'paye_le',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'paye_le' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function echeance()
    {
        return $this->belongsTo(Echeance::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
