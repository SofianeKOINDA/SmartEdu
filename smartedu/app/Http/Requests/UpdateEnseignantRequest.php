<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnseignantRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $enseignant = $this->route('enseignant');
        $userId     = $enseignant instanceof \App\Models\Enseignant ? $enseignant->user_id : null;

        return [
            // Champs User
            'nom'                  => ['sometimes', 'string', 'max:100'],
            'prenom'               => ['sometimes', 'string', 'max:100'],
            'email'                => ['sometimes', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
            // Champs Enseignant
            'specialite'           => ['sometimes', 'nullable', 'string', 'max:150'],
            'telephone'            => ['sometimes', 'nullable', 'string', 'max:20'],
            'matricule_enseignant' => ['sometimes', 'string', 'max:50', Rule::unique('enseignants', 'matricule_enseignant')->ignore($enseignant)],
        ];
    }
}
