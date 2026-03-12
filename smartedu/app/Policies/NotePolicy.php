<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class NotePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Note $note): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->etudiant && $user->etudiant->id === $note->etudiant_id;
        }

        return ($this->isManagerOrAbove($user) || $this->isEnseignant($user))
            && $this->sameTenant($user, $note);
    }

    public function create(User $user): bool
    {
        return $this->isEnseignant($user) || $this->isManagerOrAbove($user);
    }

    public function update(User $user, Note $note): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $note);
    }

    public function delete(User $user, Note $note): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $note);
    }
}
