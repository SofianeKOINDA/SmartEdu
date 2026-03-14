<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class TransactionPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function view(User $user, Transaction $transaction): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $transaction);
    }

    public function create(User $user): bool
    {
        // Les transactions sont créées automatiquement lors des paiements
        return false;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return false; // Les transactions ne sont pas modifiables
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return false; // Les transactions ne sont pas supprimables
    }
}
