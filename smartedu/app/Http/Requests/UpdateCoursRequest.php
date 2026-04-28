<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('cours'));
    }

    public function rules(): array
    {
        return [
            'enseignant_id'  => ['nullable', 'exists:enseignants,id'],
            'intitule'       => ['sometimes', 'string', 'max:255'],
            'coefficient'    => ['sometimes', 'numeric', 'min:0'],
            'volume_horaire' => ['sometimes', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'enseignant_id.exists'   => 'L\'enseignant sélectionné est invalide.',
            'intitule.string'        => 'Le champ intitulé doit être une chaîne de caractères.',
            'intitule.max'           => 'Le champ intitulé ne doit pas dépasser 255 caractères.',
            'coefficient.numeric'    => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'        => 'Le champ coefficient doit être au moins 0.',
            'volume_horaire.integer' => 'Le champ volume horaire doit être un entier.',
            'volume_horaire.min'     => 'Le champ volume horaire doit être au moins 0.',
        ];
    }
}
