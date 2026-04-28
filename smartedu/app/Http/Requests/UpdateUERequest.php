<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('ue'));
    }

    public function rules(): array
    {
        return [
            'nom'         => ['sometimes', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'coefficient' => ['sometimes', 'numeric', 'min:0'],
            'credit'      => ['sometimes', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'    => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'code.string' => 'Le champ code doit être une chaîne de caractères.',
            'code.max'    => 'Le champ code ne doit pas dépasser 20 caractères.',
            'coefficient.numeric' => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'     => 'Le champ coefficient doit être au moins 0.',
            'credit.integer'     => 'Le champ crédit doit être un entier.',
            'credit.min'         => 'Le champ crédit doit être au moins 0.',
        ];
    }
}
