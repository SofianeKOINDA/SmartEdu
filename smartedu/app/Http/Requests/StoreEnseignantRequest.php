<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Champs User
            'nom'                  => ['required', 'string', 'max:100'],
            'prenom'               => ['required', 'string', 'max:100'],
            'email'                => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'             => ['required', 'string', 'min:8', 'confirmed'],
            // Champs Enseignant
            'specialite'           => ['nullable', 'string', 'max:150'],
            'telephone'            => ['nullable', 'string', 'max:20'],
            'matricule_enseignant' => ['required', 'string', 'max:50', 'unique:enseignants,matricule_enseignant'],
        ];
    }
}
