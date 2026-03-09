<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre'               => ['sometimes', 'string', 'max:200'],
            'enseignant_matricule'=> ['sometimes', 'string', 'exists:enseignants,matricule_enseignant'],
            'type'                => ['sometimes', 'in:presentiel,en_ligne,hybride'],
            'description'         => ['sometimes', 'nullable', 'string'],
        ];
    }
}
