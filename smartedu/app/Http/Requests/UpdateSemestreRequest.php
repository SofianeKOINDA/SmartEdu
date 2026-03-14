<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('semestre'));
    }

    public function rules(): array
    {
        return [
            'nom'        => ['sometimes', 'string', 'max:100'],
            'date_debut' => ['nullable', 'date'],
            'date_fin'   => ['nullable', 'date'],
            'actif'      => ['boolean'],
        ];
    }
}
