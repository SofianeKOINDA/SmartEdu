<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEtudiantRequest extends FormRequest
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
            'utilisateur_id' => ['required', 'integer', 'exists:users,id', Rule::unique('etudiants', 'utilisateur_id')->ignore($this->route('etudiant'))],
            'matricule' => ['required', 'string', 'max:50', Rule::unique('etudiants', 'matricule')->ignore($this->route('etudiant'))],
            'date_naissance' => ['nullable', 'date'],
            'classe_id' => ['nullable', 'integer', 'exists:classes,id'],
        ];
    }
}
