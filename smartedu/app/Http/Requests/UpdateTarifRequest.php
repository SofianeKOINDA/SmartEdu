<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarifRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('tarif'));
    }

    public function rules(): array
    {
        return [
            'montant_total'    => ['sometimes', 'numeric', 'min:0'],
            'nombre_echeances' => ['sometimes', 'integer', 'min:1', 'max:12'],
            'jour_limite'      => ['sometimes', 'integer', 'min:1', 'max:28'],
        ];
    }
}
