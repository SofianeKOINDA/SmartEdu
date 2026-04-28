<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('etudiant'));
    }

    public function rules(): array
    {
        return [
            'promotion_id'   => ['sometimes', 'exists:promotions,id'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'nationalite'    => ['nullable', 'string', 'max:100'],
            'actif'          => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'promotion_id.exists'   => 'La promotion sélectionnée est invalide.',
            'date_naissance.date'  => 'Le champ date de naissance doit être une date valide.',
            'lieu_naissance.string' => 'Le champ lieu de naissance doit être une chaîne de caractères.',
            'lieu_naissance.max'   => 'Le champ lieu de naissance ne doit pas dépasser 255 caractères.',
            'nationalite.string'    => 'Le champ nationalité doit être une chaîne de caractères.',
            'nationalite.max'       => 'Le champ nationalité ne doit pas dépasser 100 caractères.',
            'actif.boolean'         => 'Le champ actif doit être un booléen.',
        ];
    }
}
