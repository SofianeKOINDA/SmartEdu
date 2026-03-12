<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('etudiant'));
    }

    public function rules(): array
    {
        return [
            'promotion_id'   => ['sometimes', 'exists:promotions,id'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'nationalite'    => ['nullable', 'string', 'max:100'],
            'actif'          => ['boolean'],
        ];
    }
}
