<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('demande'));
    }

    public function rules(): array
    {
        return [
            'statut'  => ['sometimes', 'in:en_attente,en_cours,traitee,rejetee,annulee'],
            'reponse' => ['nullable', 'string'],
        ];
    }
}
