<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Semestre::class);
    }

    public function rules(): array
    {
        return [
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'nom'               => ['required', 'string', 'max:100'],
            'numero'            => ['required', 'integer', 'min:1'],
            'date_debut'        => ['nullable', 'date'],
            'date_fin'          => ['nullable', 'date', 'after_or_equal:date_debut'],
        ];
    }
    public function messages(): array
    {
        return [
            'annee_scolaire_id.required' => 'Le champ année scolaire est obligatoire.',
            'annee_scolaire_id.exists'   => 'L\'année scolaire sélectionnée est invalide.',
            'nom.required'               => 'Le champ nom est obligatoire.',
            'nom.string'                 => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'                    => 'Le champ nom ne doit pas dépasser 100 caractères.',
            'numero.required'            => 'Le champ numéro est obligatoire.',
            'numero.integer'             => 'Le champ numéro doit être un entier.',
            'numero.min'                 => 'Le champ numéro doit être au moins 1.',
            'date_debut.date'           => 'Le champ date de début doit être une date valide.',
            'date_fin.date'             => 'Le champ date de fin doit être une date valide.',
            'date_fin.after_or_equal'   => 'La date de fin doit être postérieure ou égale à la date de début.',
        ];
    }
}
