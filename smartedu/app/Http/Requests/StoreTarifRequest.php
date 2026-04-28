<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Tarif::class);
    }

    public function rules(): array
    {
        return [
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'montant_total'     => ['required', 'numeric', 'min:0'],
            'nombre_echeances'  => ['required', 'integer', 'min:1', 'max:12'],
            'jour_limite'       => ['required', 'integer', 'min:1', 'max:28'],
        ];
    }
    public function messages(): array
    {
        return [
            'annee_scolaire_id.required' => 'Le champ année scolaire est obligatoire.',
            'annee_scolaire_id.exists'   => 'L\'année scolaire sélectionnée est invalide.',
            'montant_total.required'     => 'Le champ montant total est obligatoire.',
            'montant_total.numeric'      => 'Le champ montant total doit être un nombre.',
            'montant_total.min'          => 'Le champ montant total doit être au moins 0.',
            'nombre_echeances.required'  => 'Le champ nombre d\'échéances est obligatoire.',
            'nombre_echeances.integer'   => 'Le champ nombre d\'échéances doit être un entier.',
            'nombre_echeances.min'       => 'Le champ nombre d\'échéances doit être au moins 1.',
            'nombre_echeances.max'       => 'Le champ nombre d\'échéances ne doit pas dépasser 12.',
            'jour_limite.required'       => 'Le champ jour limite est obligatoire.',
            'jour_limite.integer'        => 'Le champ jour limite doit être un entier.',
            'jour_limite.min'            => 'Le champ jour limite doit être au moins 1.',
            'jour_limite.max'            => 'Le champ jour limite ne doit pas dépasser 28.',
        ];
    }
}
