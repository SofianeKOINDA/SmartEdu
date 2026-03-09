<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cours_id' => ['required', 'integer', 'exists:cours,id'],
            'titre' => ['required', 'string', 'max:200'],
            'type' => ['required', 'in:devoir,examen,qcm,projet,oral'],
            'description' => ['nullable', 'string'],
            'date_limite' => ['nullable', 'date'],
            'coefficient' => ['required', 'numeric', 'min:0', 'max:99.99'],
        ];
    }
    public function messages()
    {
        return [
            'cours_id.required' => 'L\'ID du cours est requis.',
            'cours_id.integer' => 'L\'ID du cours doit être un entier.',
            'cours_id.exists' => 'Le cours spécifié n\'existe pas.',
            'titre.required' => 'Le titre de l\'évaluation est requis.',
            'titre.string' => 'Le titre de l\'évaluation doit être une chaîne de caractères.',
            'titre.max' => 'Le titre de l\'évaluation ne peut pas dépasser 200 caractères.',
            'type.required' => 'Le type de l\'évaluation est requis.',
            'type.in' => 'Le type de l\'évaluation doit être l\'un des suivants : devoir, examen, qcm, projet, oral.',
            'description.string' => 'La description de l\'évaluation doit être une chaîne de caractères.',
            'date_limite.date' => 'La date limite doit être une date valide.',
            'coefficient.required' => 'Le coefficient de l\'évaluation est requis.',
            'coefficient.numeric' => 'Le coefficient de l\'évaluation doit être un nombre.',
            'coefficient.min' => 'Le coefficient de l\'évaluation doit être au moins 0.',
            'coefficient.max' => 'Le coefficient de l\'évaluation ne peut pas dépasser 99.99.',
        ];
    }
}
