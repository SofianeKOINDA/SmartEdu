<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnneeScolaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\AnneeScolaire::class);
    }

    public function rules(): array
    {
        return [
            'libelle'    => ['required', 'string', 'max:20'],
            'date_debut' => ['required', 'date'],
            'date_fin'   => ['required', 'date', 'after:date_debut'],
            'courante'   => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'libelle.required'    => 'Le champ libellé est obligatoire.',
            'libelle.string'      => 'Le champ libellé doit être une chaîne de caractères.',
            'libelle.max'         => 'Le champ libellé ne doit pas dépasser 20 caractères.',
            'date_debut.required' => 'Le champ date de début est obligatoire.',
            'date_debut.date'     => 'Le champ date de début doit être une date valide.',
            'date_fin.required'   => 'Le champ date de fin est obligatoire.',
            'date_fin.date'       => 'Le champ date de fin doit être une date valide.',
            'date_fin.after'      => 'La date de fin doit être postérieure à la date de début.',
            'courante.boolean'    => 'Le champ courante doit être un booléen.',
        ];
    }
}
