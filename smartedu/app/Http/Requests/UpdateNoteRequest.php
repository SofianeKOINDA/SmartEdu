<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
            'etudiant_id' => ['required', 'integer', 'exists:etudiants,id'],
            'evaluation_id' => ['required', 'integer', 'exists:evaluations,id'],
            'valeur' => ['required', 'numeric', 'min:0', 'max:999.99'],
            'commentaire' => ['nullable', 'string'],
            'semestre' => ['required', 'in:S1,S2,S3,S4,S5,S6'],
        ];
    }
}
