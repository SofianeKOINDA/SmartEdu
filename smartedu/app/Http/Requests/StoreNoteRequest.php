<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['required', 'string', 'exists:etudiants,matricule'],
            'evaluation_id'      => ['required', 'integer', 'exists:evaluations,id'],
            'valeur'             => ['required', 'numeric', 'min:0', 'max:20'],
            'commentaire'        => ['nullable', 'string'],
            'semestre'           => ['required', 'in:S1,S2,S3,S4,S5,S6'],
        ];
    }
    public function messages()
    {
        return [
            'etudiant_matricule.required' => 'Le matricule de l\'étudiant est requis.',
            'evaluation_id.required' => 'L\'ID de l\'évaluation est requis.',
            'valeur.required' => 'La valeur de la note est requise.',
            'semestre.required' => 'Le semestre est requis.',
        ];
    }
}
