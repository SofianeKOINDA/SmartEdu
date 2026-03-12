<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaculteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Faculte::class);
    }

    public function rules(): array
    {
        return [
            'nom'         => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
        ];
    }
}
