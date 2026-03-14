<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('tenant'));
    }

    public function rules(): array
    {
        return [
            'plan_id'    => ['sometimes', 'exists:plans,id'],
            'nom'        => ['sometimes', 'string', 'max:255'],
            'slug'       => ['sometimes', 'string', 'max:100', 'unique:tenants,slug,' . $this->route('tenant')?->id],
            'email'      => ['nullable', 'email', 'max:255'],
            'telephone'  => ['nullable', 'string', 'max:20'],
            'adresse'    => ['nullable', 'string', 'max:500'],
        ];
    }
}
