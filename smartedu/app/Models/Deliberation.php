<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliberation extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'etudiant_id',
        'semestre_id',
        'moyenne',
        'decision',
        'observation',
        'delibere_par',
        'delibere_le',
    ];

    protected $casts = [
        'moyenne' => 'decimal:2',
        'delibere_le' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function deliberePar()
    {
        return $this->belongsTo(User::class, 'delibere_par');
    }
}
