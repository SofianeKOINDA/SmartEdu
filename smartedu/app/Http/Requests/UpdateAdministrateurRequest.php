<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdministrateurRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $administrateur = $this->route('administrateur');
        $userId         = $administrateur instanceof \App\Models\Administrateur ? $administrateur->user_id : null;

        return [
            // Champs User
            'nom'                      => ['sometimes', 'string', 'max:100'],
            'prenom'                   => ['sometimes', 'string', 'max:100'],
            'email'                    => ['sometimes', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'password'                 => ['nullable', 'string', 'min:8', 'confirmed'],
            // Champs Administrateur
            'departement'              => ['sometimes', 'string', 'max:150'],
            'telephone'                => ['sometimes', 'string', 'max:20'],
            'matricule_administrateur' => ['sometimes', 'string', 'max:50', Rule::unique('administrateurs', 'matricule_administrateur')->ignore($administrateur)],
        ];
    }
}
