<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['sometimes', 'string', 'exists:etudiants,matricule'],
            'cours_id'           => ['sometimes', 'integer', 'exists:cours,id'],
            'date'               => ['sometimes', 'date'],
            'statut'             => ['sometimes', 'in:present,absent,retard,justifie'],
        ];
    }
}
