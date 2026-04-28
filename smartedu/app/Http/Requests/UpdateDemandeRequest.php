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
    public function messages(): array
    {
        return [
            'statut.in' => 'Le champ statut doit être l\'un des suivants : en_attente, en_cours, traitee, rejetee, annulee.',
            'reponse.string' => 'Le champ réponse doit être une chaîne de caractères.',
        ];
    }
}
