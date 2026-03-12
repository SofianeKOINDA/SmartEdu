<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'faculte_id',
        'nom',
        'code',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function faculte()
    {
        return $this->belongsTo(Faculte::class);
    }

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }

    public function enseignants()
    {
        return $this->hasMany(Enseignant::class);
    }
}
