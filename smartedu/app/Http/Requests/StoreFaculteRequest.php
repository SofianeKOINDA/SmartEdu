<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaculteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Faculte::class);
    }

    public function rules(): array
    {
        return [
            'nom'         => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'nom.required'  => 'Le champ nom est obligatoire.',
            'nom.string'    => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'       => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'code.string'   => 'Le champ code doit être une chaîne de caractères.',
            'code.max'      => 'Le champ code ne doit pas dépasser 20 caractères.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
        ];
    }
}
