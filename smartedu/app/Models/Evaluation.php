<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'cours_id',
        'intitule',
        'type',
        'coefficient',
        'note_max',
        'date_evaluation',
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
        'note_max' => 'decimal:2',
        'date_evaluation' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
