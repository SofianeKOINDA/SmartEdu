<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Demande::class);
    }

    public function rules(): array
    {
        return [
            'type'  => ['required', 'in:attestation,releve_notes,certificat,autre'],
            'motif' => ['nullable', 'string', 'max:1000'],
        ];
    }
    public function messages(): array
    {
        return [
            'type.required' => 'Le champ type est obligatoire.',
            'type.in'       => 'Le champ type doit être l\'un des suivants : attestation, releve_notes, certificat, autre.',
            'motif.string'  => 'Le champ motif doit être une chaîne de caractères.',
            'motif.max'     => 'Le champ motif ne doit pas dépasser 1000 caractères.',
        ];
    }
}
