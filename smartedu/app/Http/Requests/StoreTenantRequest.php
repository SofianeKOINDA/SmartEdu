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
    public function messages(): array
    {
        return [
            'plan_id.required' => 'Le champ plan est obligatoire.',
            'plan_id.exists'   => 'Le plan sélectionné est invalide.',
            'nom.required'     => 'Le champ nom est obligatoire.',
            'nom.string'       => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max'          => 'Le champ nom ne doit pas dépasser 255 caractères.',
            'slug.required'    => 'Le champ slug est obligatoire.',
            'slug.string'      => 'Le champ slug doit être une chaîne de caractères.',
            'slug.max'         => 'Le champ slug ne doit pas dépasser 100 caractères.',
            'slug.unique'      => 'Le slug doit être unique parmi les tenants existants.',
            'email.email'      => 'Le champ email doit être une adresse email valide.',
            'email.max'        => 'Le champ email ne doit pas dépasser 255 caractères.',
            'telephone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
            'telephone.max'    => 'Le champ téléphone ne doit pas dépasser 20 caractères.',
            'adresse.string'   => 'Le champ adresse doit être une chaîne de caractères.',
            'adresse.max'      => 'Le champ adresse ne doit pas dépasser 500 caractères.',
        ];
    }
}
