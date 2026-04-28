<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('evaluation'));
    }

    public function rules(): array
    {
        return [
            'intitule'        => ['sometimes', 'string', 'max:255'],
            'type'            => ['sometimes', 'in:devoir,examen,tp,projet,autre'],
            'coefficient'     => ['sometimes', 'numeric', 'min:0'],
            'note_max'        => ['sometimes', 'numeric', 'min:1'],
            'date_evaluation' => ['nullable', 'date'],
        ];
    }
    public function messages(): array
    {
        return [
            'intitule.string'          => 'Le champ intitulé doit être une chaîne de caractères.',
            'intitule.max'             => 'Le champ intitulé ne doit pas dépasser 255 caractères.',
            'type.in'                  => 'Le champ type doit être l\'un des suivants : devoir, examen, tp, projet, autre.',
            'coefficient.numeric'      => 'Le champ coefficient doit être un nombre.',
            'coefficient.min'          => 'Le champ coefficient doit être au moins 0.',
            'note_max.numeric'         => 'Le champ note max doit être un nombre.',
            'note_max.min'             => 'Le champ note max doit être au moins 1.',
            'date_evaluation.date'     => 'Le champ date d\'évaluation doit être une date valide.',
        ];
    }
}
