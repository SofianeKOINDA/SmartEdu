<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('promotion'));
    }

    public function rules(): array
    {
        return [
            'filiere_id'        => ['sometimes', 'exists:filieres,id'],
            'annee_scolaire_id' => ['sometimes', 'exists:annees_scolaires,id'],
            'nom'               => ['sometimes', 'string', 'max:255'],
            'niveau'            => ['sometimes', 'integer', 'min:1'],
        ];
    }
    public function messages(): array
    {
        return [
            'filiere_id.exists' => 'La filière sélectionnée est invalide.',
            'annee_scolaire_id.exists' => 'L\'année scolaire sélectionnée est invalide.',
            'nom.string'        => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'           => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'niveau.integer'    => 'Le champ niveau doit être un entier.',
            'niveau.min'        => 'Le champ niveau doit être au moins 1.',
        ];
    }
}
