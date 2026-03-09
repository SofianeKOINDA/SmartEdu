<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'etudiant_id' => ['required', 'integer', 'exists:etudiants,id'],
            'cours_id' => ['required', 'integer', 'exists:cours,id'],
            'date' => ['required', 'date'],
            'statut' => ['required', 'in:present,absent,retard,justifie'],
        ];
    }
}
