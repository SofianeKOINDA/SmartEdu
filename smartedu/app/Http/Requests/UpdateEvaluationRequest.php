<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cours_id'    => ['sometimes', 'integer', 'exists:cours,id'],
            'titre'       => ['sometimes', 'string', 'max:200'],
            'type'        => ['sometimes', 'in:devoir,examen,qcm,projet,oral'],
            'description' => ['sometimes', 'nullable', 'string'],
            'date_limite' => ['sometimes', 'nullable', 'date'],
            'coefficient' => ['sometimes', 'numeric', 'min:0', 'max:99.99'],
        ];
    }

    public function messages()
    {
        return [
            'cours_id.integer' => 'L\'ID du cours doit être un entier.',
            'cours_id.exists' => 'Le cours spécifié n\'existe pas.',
            'titre.string' => 'Le titre de l\'évaluation doit être une chaîne de caractères.',
            'titre.max' => 'Le titre de l\'évaluation ne peut pas dépasser 200 caractères.',
            'type.in' => 'Le type de l\'évaluation doit être l\'un des suivants : devoir, examen, qcm, projet, oral.',
            'description.string' => 'La description de l\'évaluation doit être une chaîne de caractères.',
            'date_limite.date' => 'La date limite doit être une date valide.',
            'coefficient.numeric' => 'Le coefficient de l\'évaluation doit être un nombre.',
            'coefficient.min' => 'Le coefficient de l\'évaluation doit être au moins 0.',
            'coefficient.max' => 'Le coefficient de l\'évaluation ne peut pas dépasser 99.99.',
        ];
    }
}
