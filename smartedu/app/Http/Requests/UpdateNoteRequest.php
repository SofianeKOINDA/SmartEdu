<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['sometimes', 'string', 'exists:etudiants,matricule'],
            'evaluation_id'      => ['sometimes', 'integer', 'exists:evaluations,id'],
            'valeur'             => ['sometimes', 'numeric', 'min:0', 'max:20'],
            'commentaire'        => ['sometimes', 'nullable', 'string'],
            'semestre'           => ['sometimes', 'in:S1,S2,S3,S4,S5,S6'],
        ];
    }
}
