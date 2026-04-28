<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Departement::class);
    }

    public function rules(): array
    {
        return [
            'faculte_id' => ['required', 'exists:facultes,id'],
            'nom'        => ['required', 'string', 'max:255'],
            'code'       => ['nullable', 'string', 'max:20'],
        ];
    }
    public function messages(): array
    {
        return [
            'faculte_id.required' => 'Le champ faculté est obligatoire.',
            'faculte_id.exists'   => 'La faculté sélectionnée est invalide.',
            'nom.required'        => 'Le champ nom est obligatoire.',
            'nom.string'          => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'             => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'code.string'         => 'Le champ code doit être une chaîne de caractères.',
            'code.max'            => 'Le champ code ne doit pas dépasser 20 caractères.',
        ];
    }
}
