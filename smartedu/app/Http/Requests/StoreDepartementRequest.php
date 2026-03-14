<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Departement::class);
    }

    public function rules(): array
    {
        return [
            'faculte_id' => ['required', 'exists:facultes,id'],
            'nom'        => ['required', 'string', 'max:255'],
            'code'       => ['nullable', 'string', 'max:20'],
        ];
    }
}
