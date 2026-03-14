<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class TenantPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    public function view(User $user, Tenant $tenant): bool
    {
        return $this->isSuperAdmin($user) || $user->tenant_id === $tenant->id;
    }

    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $this->isSuperAdmin($user);
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $this->isSuperAdmin($user);
    }
}
