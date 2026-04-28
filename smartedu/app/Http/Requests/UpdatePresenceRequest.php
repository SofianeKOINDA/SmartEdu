<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('presence'));
    }

    public function rules(): array
    {
        return [
            'statut'      => ['sometimes', 'in:present,absent,retard,excuse'],
            'observation' => ['nullable', 'string'],
        ];
    }
   
}
