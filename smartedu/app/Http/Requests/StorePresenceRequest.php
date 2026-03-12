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
}
