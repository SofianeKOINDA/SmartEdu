<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('promotion'));
    }

    public function rules(): array
    {
        return [
            'filiere_id'        => ['sometimes', 'exists:filieres,id'],
            'annee_scolaire_id' => ['sometimes', 'exists:annees_scolaires,id'],
            'nom'               => ['sometimes', 'string', 'max:255'],
            'niveau'            => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
