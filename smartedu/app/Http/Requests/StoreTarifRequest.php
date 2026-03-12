<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Tarif::class);
    }

    public function rules(): array
    {
        return [
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'montant_total'     => ['required', 'numeric', 'min:0'],
            'nombre_echeances'  => ['required', 'integer', 'min:1', 'max:12'],
            'jour_limite'       => ['required', 'integer', 'min:1', 'max:28'],
        ];
    }
}
