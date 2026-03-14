<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnseignantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('enseignant'));
    }

    public function rules(): array
    {
        return [
            'departement_id' => ['nullable', 'exists:departements,id'],
            'grade'          => ['nullable', 'string', 'max:100'],
            'specialite'     => ['nullable', 'string', 'max:255'],
            'bureau'         => ['nullable', 'string', 'max:100'],
            'matricule'      => ['nullable', 'string', 'max:50'],
        ];
    }
}
