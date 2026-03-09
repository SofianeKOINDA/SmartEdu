<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtudiantRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Champs User
            'nom'            => ['required', 'string', 'max:100'],
            'prenom'         => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            // Champs Etudiant
            'matricule'      => ['required', 'string', 'max:50', 'unique:etudiants,matricule'],
            'date_naissance' => ['nullable', 'date'],
            'classe_id'      => ['nullable', 'integer', 'exists:classes,id'],
        ];
    }
}
