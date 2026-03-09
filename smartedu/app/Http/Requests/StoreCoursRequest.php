<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre'               => ['required', 'string', 'max:200'],
            'enseignant_matricule'=> ['required', 'string', 'exists:enseignants,matricule_enseignant'],
            'type'                => ['required', 'in:presentiel,en_ligne,hybride'],
            'description'         => ['nullable', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Le titre du cours est requis.',
            'enseignant_matricule.required' => 'Le matricule de l\'enseignant est requis.',
            'type.required' => 'Le type de cours est requis.',
            'type.in' => 'Le type de cours doit être présentiel, en ligne ou hybride.',
        ];
    }
}
