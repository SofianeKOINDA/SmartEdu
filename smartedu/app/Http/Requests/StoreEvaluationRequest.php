<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Evaluation::class);
    }

    public function rules(): array
    {
        return [
            'cours_id'         => ['required', 'exists:cours,id'],
            'intitule'         => ['required', 'string', 'max:255'],
            'type'             => ['required', 'in:devoir,examen,tp,projet,autre'],
            'coefficient'      => ['required', 'numeric', 'min:0'],
            'note_max'         => ['required', 'numeric', 'min:1'],
            'date_evaluation'  => ['nullable', 'date'],
        ];
    }
}
