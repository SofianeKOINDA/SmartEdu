<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Note::class);
    }

    public function rules(): array
    {
        return [
            'evaluation_id' => ['required', 'exists:evaluations,id'],
            'etudiant_id'   => ['required', 'exists:etudiants,id'],
            'valeur'        => ['required', 'numeric', 'min:0'],
            'commentaire'   => ['nullable', 'string'],
        ];
    }
}
