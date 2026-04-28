<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('note'));
    }

    public function rules(): array
    {
        return [
            'valeur'      => ['sometimes', 'numeric', 'min:0'],
            'commentaire' => ['nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'valeur.numeric' => 'Le champ valeur doit être un nombre.',
            'valeur.min'     => 'Le champ valeur doit être au moins 0.',
            'commentaire.string' => 'Le champ commentaire doit être une chaîne de caractères.',
        ];
    }
}
