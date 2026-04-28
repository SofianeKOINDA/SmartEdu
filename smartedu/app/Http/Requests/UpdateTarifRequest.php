<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('tarif'));
    }

    public function rules(): array
    {
        return [
            'montant_total'    => ['sometimes', 'numeric', 'min:0'],
            'nombre_echeances' => ['sometimes', 'integer', 'min:1', 'max:12'],
            'jour_limite'      => ['sometimes', 'integer', 'min:1', 'max:28'],
        ];
    }
    public function messages(): array
    {
        return [
            'montant_total.numeric' => 'Le champ montant total doit être un nombre.',
            'montant_total.min'     => 'Le champ montant total doit être au moins 0.',
            'nombre_echeances.integer' => 'Le champ nombre d\'échéances doit être un entier.',
            'nombre_echeances.min'     => 'Le champ nombre d\'échéances doit être au moins 1.',
            'nombre_echeances.max'     => 'Le champ nombre d\'échéances ne doit pas dépasser 12.',
            'jour_limite.integer'      => 'Le champ jour limite doit être un entier.',
            'jour_limite.min'          => 'Le champ jour limite doit être au moins 1.',
            'jour_limite.max'          => 'Le champ jour limite ne doit pas dépasser 28.',
        ];
    }
}
