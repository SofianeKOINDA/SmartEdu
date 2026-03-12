<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UE extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'ues';

    protected $fillable = [
        'tenant_id',
        'semestre_id',
        'nom',
        'code',
        'coefficient',
        'credit',
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'ue_id');
    }
}
