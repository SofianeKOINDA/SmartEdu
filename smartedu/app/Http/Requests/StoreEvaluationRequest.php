<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
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
            'cours_id' => ['required', 'integer', 'exists:cours,id'],
            'titre' => ['required', 'string', 'max:200'],
            'type' => ['required', 'in:devoir,examen,qcm,projet,oral'],
            'description' => ['nullable', 'string'],
            'date_limite' => ['nullable', 'date'],
            'coefficient' => ['required', 'numeric', 'min:0', 'max:99.99'],
        ];
    }
}
