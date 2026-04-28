<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Note::class);
    }

    public function rules(): array
    {
        return [
            'evaluation_id' => ['required', 'exists:evaluations,id'],
            'etudiant_id'   => ['required', 'exists:etudiants,id'],
            'valeur'        => ['required', 'numeric', 'min:0'],
            'commentaire'   => ['nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'evaluation_id.required' => 'Le champ évaluation est obligatoire.',
            'evaluation_id.exists'   => 'L\'évaluation sélectionnée est invalide.',
            'etudiant_id.required'   => 'Le champ étudiant est obligatoire.',
            'etudiant_id.exists'     => 'L\'étudiant sélectionné est invalide.',
            'valeur.required'        => 'Le champ valeur est obligatoire.',
            'valeur.numeric'         => 'Le champ valeur doit être un nombre.',
            'valeur.min'             => 'Le champ valeur doit être au moins 0.',
            'commentaire.string'     => 'Le champ commentaire doit être une chaîne de caractères.',
        ];
    }
}
