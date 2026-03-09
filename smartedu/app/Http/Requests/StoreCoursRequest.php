<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
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
            'titre' => ['required', 'string', 'max:200'],
            'enseignant_id' => ['required', 'integer', 'exists:enseignants,id'],
            'type' => ['required', 'in:presentiel,en_ligne,hybride'],
            'description' => ['nullable', 'string'],
        ];
    }
}
