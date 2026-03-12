<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculte extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'nom',
        'code',
        'description',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }
}
