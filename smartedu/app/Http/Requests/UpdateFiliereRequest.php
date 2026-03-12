<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('filiere'));
    }

    public function rules(): array
    {
        return [
            'departement_id' => ['sometimes', 'exists:departements,id'],
            'nom'            => ['sometimes', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'duree_annees'   => ['sometimes', 'integer', 'min:1', 'max:10'],
        ];
    }
}
