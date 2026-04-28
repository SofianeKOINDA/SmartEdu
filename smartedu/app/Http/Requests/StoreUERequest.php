<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\UE::class);
    }

    public function rules(): array
    {
        return [
            'semestre_id'  => ['required', 'exists:semestres,id'],
            'nom'          => ['required', 'string', 'max:255'],
            'code'         => ['nullable', 'string', 'max:20'],
            'coefficient'  => ['required', 'numeric', 'min:0'],
            'credit'       => ['required', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'semestre_id.required' => 'Le champ semestre est obligatoire.',
            'semestre_id.exists'   => 'Le semestre sélectionné est invalide.',
            'nom.required'         => 'Le champ nom est obligatoire.',
            'nom.string'           => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'              => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'code.string'          => 'Le champ code doit être une chaîne de caractères.',
            'code.max'             => 'Le champ code ne doit pas dépasser 20 caractères.',
            'coefficient.required' => 'Le champ coefficient est obligatoire.',
            'coefficient.numeric'  => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'      => 'Le champ coefficient doit être au moins 0.',
            'credit.required'      => 'Le champ crédit est obligatoire.',
            'credit.integer'       => 'Le champ crédit doit être un entier.',
            'credit.min'           => 'Le champ crédit doit être au moins 0.',
        ];
    }
}
