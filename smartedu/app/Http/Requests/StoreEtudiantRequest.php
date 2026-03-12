<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Etudiant::class);
    }

    public function rules(): array
    {
        return [
            'user_id'          => ['required', 'exists:users,id'],
            'promotion_id'     => ['required', 'exists:promotions,id'],
            'numero_etudiant'  => ['nullable', 'string', 'max:50'],
            'date_naissance'   => ['nullable', 'date'],
            'lieu_naissance'   => ['nullable', 'string', 'max:255'],
            'nationalite'      => ['nullable', 'string', 'max:100'],
        ];
    }
}
