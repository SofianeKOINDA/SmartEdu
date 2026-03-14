<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnneeScolaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('annee_scolaire'));
    }

    public function rules(): array
    {
        return [
            'libelle'    => ['sometimes', 'string', 'max:20'],
            'date_debut' => ['sometimes', 'date'],
            'date_fin'   => ['sometimes', 'date', 'after:date_debut'],
            'courante'   => ['boolean'],
        ];
    }
}
