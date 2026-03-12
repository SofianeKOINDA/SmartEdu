<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'cours_id',
        'etudiant_id',
        'saisi_par',
        'date_seance',
        'statut',
        'observation',
    ];

    protected $casts = [
        'date_seance' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function saisiPar()
    {
        return $this->belongsTo(User::class, 'saisi_par');
    }
}
