<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Presence::class);
    }

    public function rules(): array
    {
        return [
            'cours_id'    => ['required', 'exists:cours,id'],
            'etudiant_id' => ['required', 'exists:etudiants,id'],
            'date_seance' => ['required', 'date'],
            'statut'      => ['required', 'in:present,absent,retard,excuse'],
            'observation' => ['nullable', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'cours_id.required' => 'Le champ cours est obligatoire.',
            'etudiant_id.required' => 'Le champ étudiant est obligatoire.',
            'date_seance.required' => 'Le champ date de séance est obligatoire.',
            'statut.required' => 'Le champ statut est obligatoire.',
            'statut.in' => 'Le champ statut doit être l\'un des suivants : present, absent, retard, excuse.',
        ];
    }
}
