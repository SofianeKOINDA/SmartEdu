<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClasseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'           => ['sometimes', 'string', 'max:100'],
            'niveau'        => ['sometimes', 'string', 'max:50'],
            'annee_scolaire'=> ['sometimes', 'string', 'max:20'],
        ];
    }
    public function messages()
    {
        return [
            'nom.string' => 'Le nom de la classe doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de la classe ne peut pas dépasser 100 caractères.',
            'niveau.string' => 'Le niveau de la classe doit être une chaîne de caractères.',
            'niveau.max' => 'Le niveau de la classe ne peut pas dépasser 50 caractères.',
            'annee_scolaire.string' => 'L\'année scolaire doit être une chaîne de caractères.',
            'annee_scolaire.max' => 'L\'année scolaire ne peut pas dépasser 20 caractères.',
        ];
    }
}
