<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEtudiantRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $etudiant = $this->route('etudiant');
        $userId   = $etudiant instanceof \App\Models\Etudiant ? $etudiant->user_id : null;

        return [
            // Champs User
            'nom'            => ['sometimes', 'string', 'max:100'],
            'prenom'         => ['sometimes', 'string', 'max:100'],
            'email'          => ['sometimes', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'password'       => ['nullable', 'string', 'min:8', 'confirmed'],
            // Champs Etudiant
            'matricule'      => ['sometimes', 'string', 'max:50', Rule::unique('etudiants', 'matricule')->ignore($etudiant)],
            'date_naissance' => ['sometimes', 'nullable', 'date'],
            'classe_id'      => ['sometimes', 'nullable', 'integer', 'exists:classes,id'],
        ];
    }
}
