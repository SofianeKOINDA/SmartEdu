<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtudiantRequest extends FormRequest
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
            'utilisateur_id' => ['required', 'integer', 'exists:users,id', 'unique:etudiants,utilisateur_id'],
            'matricule' => ['required', 'string', 'max:50', 'unique:etudiants,matricule'],
            'date_naissance' => ['nullable', 'date'],
            'classe_id' => ['nullable', 'integer', 'exists:classes,id'],
        ];
    }
}
