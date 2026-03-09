<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,enseignant,etudiant'],
            'photo_profil' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'nom.required' => 'Le champ nom est requis.',
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max' => 'Le champ nom ne peut pas dépasser 100 caractères.',
            'prenom.required' => 'Le champ prénom est requis.',
            'prenom.string' => 'Le champ prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le champ prénom ne peut pas dépasser 100 caractères.',
            'email.required' => 'Le champ email est requis.',
            'email.string' => 'Le champ email doit être une chaîne de caractères.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'email.max' => 'Le champ email ne peut pas dépasser 150 caractères.',
            'email.unique' => 'L\'adresse email spécifiée est déjà utilisée par un autre utilisateur.',
            'password.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le champ mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas au mot de passe.',
            'role.string' => 'Le champ rôle doit être une chaîne de caractères.',
            'role.required' => 'Le champ rôle est requis.',
            'role.in' => 'Le champ rôle doit être l\'un des suivants : admin, enseignant, etudiant.',
            'photo_profil.string' => 'Le champ photo de profil doit être une chaîne de caractères.',
            'photo_profil.max' => 'Le champ photo de profil ne peut pas dépasser 255 caractères.',
        ];
    }
}
