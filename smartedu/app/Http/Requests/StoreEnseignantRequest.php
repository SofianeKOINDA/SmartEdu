<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Enseignant::class);
    }

    public function rules(): array
    {
        return [
            'user_id'        => ['required', 'exists:users,id'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'grade'          => ['nullable', 'string', 'max:100'],
            'specialite'     => ['nullable', 'string', 'max:255'],
            'bureau'         => ['nullable', 'string', 'max:100'],
            'matricule'      => ['nullable', 'string', 'max:50'],
        ];
    }
}
