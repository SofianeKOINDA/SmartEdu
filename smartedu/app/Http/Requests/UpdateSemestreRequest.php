<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('semestre'));
    }

    public function rules(): array
    {
        return [
            'nom'        => ['sometimes', 'string', 'max:100'],
            'date_debut' => ['nullable', 'date'],
            'date_fin'   => ['nullable', 'date'],
            'actif'      => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'    => 'Le champ nom ne doit pas dépasser 100 caractères.',
            'date_debut.date' => 'Le champ date de début doit être une date valide.',
            'date_fin.date'   => 'Le champ date de fin doit être une date valide.',
            'actif.boolean'   => 'Le champ actif doit être un booléen.',
        ];
    }
}
