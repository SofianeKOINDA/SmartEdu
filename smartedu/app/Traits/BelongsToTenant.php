<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        // Inject tenant_id automatically on creation
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->tenant_id && empty($model->tenant_id)) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });

        // Filter by tenant on every query
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', Auth::user()->tenant_id);
            }
        });
    }

    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
