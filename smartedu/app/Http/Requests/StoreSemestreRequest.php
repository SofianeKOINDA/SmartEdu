<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Semestre::class);
    }

    public function rules(): array
    {
        return [
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'nom'               => ['required', 'string', 'max:100'],
            'numero'            => ['required', 'integer', 'min:1'],
            'date_debut'        => ['nullable', 'date'],
            'date_fin'          => ['nullable', 'date', 'after_or_equal:date_debut'],
        ];
    }
}
