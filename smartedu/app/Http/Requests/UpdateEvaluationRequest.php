<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('evaluation'));
    }

    public function rules(): array
    {
        return [
            'intitule'        => ['sometimes', 'string', 'max:255'],
            'type'            => ['sometimes', 'in:devoir,examen,tp,projet,autre'],
            'coefficient'     => ['sometimes', 'numeric', 'min:0'],
            'note_max'        => ['sometimes', 'numeric', 'min:1'],
            'date_evaluation' => ['nullable', 'date'],
        ];
    }
}
