<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnneeScolaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('annee_scolaire'));
    }

    public function rules(): array
    {
        return [
            'libelle'    => ['sometimes', 'string', 'max:20'],
            'date_debut' => ['sometimes', 'date'],
            'date_fin'   => ['sometimes', 'date', 'after:date_debut'],
            'courante'   => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'libelle.string'      => 'Le champ libellé doit être une chaîne de caractères.',
            'libelle.max'         => 'Le champ libellé ne doit pas dépasser 20 caractères.',
            'date_debut.date'     => 'Le champ date de début doit être une date valide.',
            'date_fin.date'       => 'Le champ date de fin doit être une date valide.',
            'date_fin.after'      => 'La date de fin doit être postérieure à la date de début.',
            'courante.boolean'    => 'Le champ courante doit être un booléen.',
        ];
    }
}
