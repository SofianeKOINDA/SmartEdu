<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('filiere'));
    }

    public function rules(): array
    {
        return [
            'departement_id' => ['sometimes', 'exists:departements,id'],
            'nom'            => ['sometimes', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'duree_annees'   => ['sometimes', 'integer', 'min:1', 'max:10'],
        ];
    }
    public function messages(): array
    {
        return [
            'departement_id.exists' => 'Le département sélectionné est invalide.',
            'nom.string'            => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'               => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'code.string'           => 'Le champ code doit être une chaîne de caractères.',
            'code.max'              => 'Le champ code ne doit pas dépasser 20 caractères.',
            'duree_annees.integer'  => 'Le champ durée en années doit être un entier.',
            'duree_annees.min'      => 'Le champ durée en années doit être au moins 1.',
            'duree_annees.max'      => 'Le champ durée en années ne doit pas dépasser 10.',
        ];
    }
}
