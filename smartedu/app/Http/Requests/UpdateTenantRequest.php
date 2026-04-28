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
    public function messages(): array
    {
        return [
            'plan_id.exists' => 'Le plan sélectionné est invalide.',
            'nom.string'     => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'        => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'slug.string'    => 'Le champ slug doit être une chaîne de caractères.',
            'slug.max'       => 'Le champ slug ne doit pas dépasser 100 caractères.',
            'slug.unique'    => 'Le champ slug doit être unique.',
            'email.email'    => 'Le champ email doit être une adresse email valide.',
            'email.max'      => 'Le champ email ne doit pas dépasser 255 caractères.',
            'telephone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'telephone.max'    => 'Le champ téléphone ne doit pas dépasser 20 caractères.',
            'adresse.string'   => 'Le champ adresse doit être une chaîne de caractères.',
            'adresse.max'      => 'Le champ adresse ne doit pas dépasser 500 caractères.',
        ];
    }
}
