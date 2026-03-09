<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnseignantRequest extends FormRequest
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
            'utilisateur_id' => ['required', 'integer', 'exists:users,id', Rule::unique('enseignants', 'utilisateur_id')->ignore($this->route('enseignant'))],
            'specialite' => ['nullable', 'string', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:20'],
        ];
    }
}
