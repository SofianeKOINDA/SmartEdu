<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Cours::class);
    }

    public function rules(): array
    {
        return [
            'ue_id'          => ['required', 'exists:ues,id'],
            'enseignant_id'  => ['nullable', 'exists:enseignants,id'],
            'intitule'       => ['required', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'coefficient'    => ['required', 'numeric', 'min:0'],
            'volume_horaire' => ['required', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'ue_id.required'         => 'Le champ UE est obligatoire.',
            'ue_id.exists'           => 'L\'UE sélectionnée est invalide.',
            'enseignant_id.exists'   => 'L\'enseignant sélectionné est invalide.',
            'intitule.required'      => 'Le champ intitulé est obligatoire.',
            'intitule.string'        => 'Le champ intitulé doit être une chaîne de caractères.',
            'intitule.max'           => 'Le champ intitulé ne doit pas dépasser 255 caractères.',
            'code.string'           => 'Le champ code doit être une chaîne de caractères.',
            'code.max'              => 'Le champ code ne doit pas dépasser 20 caractères.',
            'coefficient.required'   => 'Le champ coefficient est obligatoire.',
            'coefficient.numeric'    => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'        => 'Le champ coefficient doit être au moins 0.',
            'volume_horaire.required'=> 'Le champ volume horaire est obligatoire.',
            'volume_horaire.integer' => 'Le champ volume horaire doit être un entier.',
            'volume_horaire.min'     => 'Le champ volume horaire doit être au moins 0.',
        ];
    }
}
