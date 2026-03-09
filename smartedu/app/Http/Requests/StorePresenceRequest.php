<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['required', 'string', 'exists:etudiants,matricule'],
            'cours_id'           => ['required', 'integer', 'exists:cours,id'],
            'date'               => ['required', 'date'],
            'statut'             => ['required', 'in:present,absent,retard,justifie'],
        ];
    }
    public function messages()
    {
        return [
            'etudiant_matricule.required' => 'Le matricule de l\'étudiant est requis.',
            'cours_id.required' => 'L\'ID du cours est requis.',
            'date.required' => 'La date est requise.',
            'statut.required' => 'Le statut est requis.',
        ];
    }
}
