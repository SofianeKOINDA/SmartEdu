<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Enseignant::class);
    }

    public function rules(): array
    {
        return [
            'user_id'        => ['required', 'exists:users,id'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'grade'          => ['nullable', 'string', 'max:100'],
            'specialite'     => ['nullable', 'string', 'max:255'],
            'bureau'         => ['nullable', 'string', 'max:100'],
            'matricule'      => ['nullable', 'string', 'max:50'],
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required'        => 'Le champ utilisateur est obligatoire.',
            'user_id.exists'          => 'L\'utilisateur sélectionné est invalide.',
            'departement_id.exists'   => 'Le département sélectionné est invalide.',
            'grade.string'           => 'Le champ grade doit être une chaîne de caractères.',
            'grade.max'              => 'Le champ grade ne doit pas dépasser 100 caractères.',
            'specialite.string'      => 'Le champ spécialité doit être une chaîne de caractères.',
            'specialite.max'         => 'Le champ spécialité ne doit pas dépasser 255 caractères.',
            'bureau.string'          => 'Le champ bureau doit être une chaîne de caractères.',
            'bureau.max'             => 'Le champ bureau ne doit pas dépasser 100 caractères.',
            'matricule.string'       => 'Le champ matricule doit être une chaîne de caractères.',
            'matricule.max'          => 'Le champ matricule ne doit pas dépasser 50 caractères.',
        ];
    }
}
