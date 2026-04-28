<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Evaluation::class);
    }

    public function rules(): array
    {
        return [
            'cours_id'         => ['required', 'exists:cours,id'],
            'intitule'         => ['required', 'string', 'max:255'],
            'type'             => ['required', 'in:devoir,examen,tp,projet,autre'],
            'coefficient'      => ['required', 'numeric', 'min:0'],
            'note_max'         => ['required', 'numeric', 'min:1'],
            'date_evaluation'  => ['nullable', 'date'],
        ];
    }
    public function messages(): array
    {
        return [
            'cours_id.required'        => 'Le champ cours est obligatoire.',
            'cours_id.exists'          => 'Le cours sélectionné est invalide.',
            'intitule.required'        => 'Le champ intitulé est obligatoire.',
            'intitule.string'          => 'Le champ intitulé doit être une chaîne de caractères.',
            'intitule.max'             => 'Le champ intitulé ne doit pas dépasser 255 caractères.',
            'type.required'            => 'Le champ type est obligatoire.',
            'type.in'                  => 'Le champ type doit être l\'un des suivants : devoir, examen, tp, projet, autre.',
            'coefficient.required'     => 'Le champ coefficient est obligatoire.',
            'coefficient.numeric'      => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'          => 'Le champ coefficient doit être au moins 0.',
            'note_max.required'        => 'Le champ note max est obligatoire.',
            'note_max.numeric'         => 'Le champ note max doit être un nombre.',
            'note_max.min'             => 'Le champ note max doit être au moins 1.',
            'date_evaluation.date'     => 'Le champ date d\'évaluation doit être une date valide.',
        ];
    }
}
