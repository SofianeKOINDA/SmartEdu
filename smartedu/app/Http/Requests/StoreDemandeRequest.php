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
}
