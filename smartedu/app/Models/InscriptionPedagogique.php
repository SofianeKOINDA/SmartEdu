<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionPedagogique extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'inscriptions_pedagogiques';

    protected $fillable = [
        'tenant_id',
        'etudiant_id',
        'cours_id',
        'date_inscription',
    ];

    protected $casts = [
        'date_inscription' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}
