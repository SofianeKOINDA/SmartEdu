<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\UE::class);
    }

    public function rules(): array
    {
        return [
            'semestre_id'  => ['required', 'exists:semestres,id'],
            'nom'          => ['required', 'string', 'max:255'],
            'code'         => ['nullable', 'string', 'max:20'],
            'coefficient'  => ['required', 'numeric', 'min:0'],
            'credit'       => ['required', 'integer', 'min:0'],
        ];
    }
}
