<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'etudiant_id',
        'type',
        'statut',
        'motif',
        'reponse',
        'traite_par',
        'traite_le',
    ];

    protected $casts = [
        'traite_le' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }
}
