<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
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
            'utilisateur_id' => ['required', 'integer', 'exists:users,id', 'unique:enseignants,utilisateur_id'],
            'specialite' => ['nullable', 'string', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:20'],
        ];
    }
}
