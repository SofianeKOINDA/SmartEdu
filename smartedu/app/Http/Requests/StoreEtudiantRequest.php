<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Etudiant::class);
    }

    public function rules(): array
    {
        return [
            'user_id'          => ['required', 'exists:users,id'],
            'promotion_id'     => ['required', 'exists:promotions,id'],
            'numero_etudiant'  => ['nullable', 'string', 'max:50'],
            'date_naissance'   => ['nullable', 'date'],
            'lieu_naissance'   => ['nullable', 'string', 'max:255'],
            'nationalite'      => ['nullable', 'string', 'max:100'],
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required'         => 'Le champ utilisateur est obligatoire.',
            'user_id.exists'           => 'L\'utilisateur sélectionné est invalide.',
            'promotion_id.required'    => 'Le champ promotion est obligatoire.',
            'promotion_id.exists'      => 'La promotion sélectionnée est invalide.',
            'numero_etudiant.string'   => 'Le champ numéro étudiant doit être une chaîne de caractères.',
            'numero_etudiant.max'      => 'Le champ numéro étudiant ne doit pas dépasser 50 caractères.',
            'date_naissance.date'     => 'Le champ date de naissance doit être une date valide.',
            'lieu_naissance.string'   => 'Le champ lieu de naissance doit être une chaîne de caractères.',
            'lieu_naissance.max'      => 'Le champ lieu de naissance ne doit pas dépasser 255 caractères.',
            'nationalite.string'      => 'Le champ nationalité doit être une chaîne de caractères.',
            'nationalite.max'         => 'Le champ nationalité ne doit pas dépasser 100 caractères.',
        ];
    }
}
