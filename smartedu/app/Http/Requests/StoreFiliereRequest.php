<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Filiere::class);
    }

    public function rules(): array
    {
        return [
            'departement_id' => ['required', 'exists:departements,id'],
            'nom'            => ['required', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'duree_annees'   => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
