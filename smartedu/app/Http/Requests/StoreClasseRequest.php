<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClasseRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:100'],
            'niveau' => ['required', 'string', 'max:50'],
            'annee_scolaire' => ['required', 'string', 'max:20'],
        ];
    }
    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la classe est requis.',
            'nom.string' => 'Le nom de la classe doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de la classe ne peut pas dépasser 100 caractères.',
            'niveau.required' => 'Le niveau de la classe est requis.',
            'niveau.string' => 'Le niveau de la classe doit être une chaîne de caractères.',
            'niveau.max' => 'Le niveau de la classe ne peut pas dépasser 50 caractères.',
            'annee_scolaire.required' => 'L\'année scolaire est requise.',
            'annee_scolaire.string' => 'L\'année scolaire doit être une chaîne de caractères.',
            'annee_scolaire.max' => 'L\'année scolaire ne peut pas dépasser 20 caractères.',
        ];
    }
}
