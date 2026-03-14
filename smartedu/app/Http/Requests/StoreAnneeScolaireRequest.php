<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnneeScolaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\AnneeScolaire::class);
    }

    public function rules(): array
    {
        return [
            'libelle'    => ['required', 'string', 'max:20'],
            'date_debut' => ['required', 'date'],
            'date_fin'   => ['required', 'date', 'after:date_debut'],
            'courante'   => ['boolean'],
        ];
    }
}
