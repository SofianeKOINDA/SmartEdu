<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class PromotionPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Promotion $promotion): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $promotion);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Promotion $promotion): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $promotion);
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $promotion);
    }
}
