<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Tenant::class);
    }

    public function rules(): array
    {
        return [
            'plan_id'    => ['required', 'exists:plans,id'],
            'nom'        => ['required', 'string', 'max:255'],
            'slug'       => ['required', 'string', 'max:100', 'unique:tenants,slug'],
            'email'      => ['nullable', 'email', 'max:255'],
            'telephone'  => ['nullable', 'string', 'max:20'],
            'adresse'    => ['nullable', 'string', 'max:500'],
        ];
    }
}
