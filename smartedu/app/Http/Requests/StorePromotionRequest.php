<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Promotion::class);
    }

    public function rules(): array
    {
        return [
            'filiere_id'         => ['required', 'exists:filieres,id'],
            'annee_scolaire_id'  => ['required', 'exists:annees_scolaires,id'],
            'nom'                => ['required', 'string', 'max:255'],
            'niveau'             => ['required', 'integer', 'min:1'],
        ];
    }
    public function messages()
    {
        return [
            'filiere_id.required' => ''
        ];
    }
}
