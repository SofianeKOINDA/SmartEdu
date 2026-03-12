<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'departement_id',
        'nom',
        'code',
        'duree_annees',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
