<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'cours_id',
        'promotion_id',
        'salle',
        'jour',
        'heure_debut',
        'heure_fin',
        'type',
        'recurrent',
        'date_specifique',
    ];

    protected $casts = [
        'recurrent' => 'boolean',
        'date_specifique' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
