<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('seance'));
    }

    public function rules(): array
    {
        return [
            'salle'           => ['nullable', 'string', 'max:50'],
            'jour'            => ['sometimes', 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi'],
            'heure_debut'     => ['sometimes', 'date_format:H:i'],
            'heure_fin'       => ['sometimes', 'date_format:H:i'],
            'type'            => ['sometimes', 'in:cm,td,tp'],
            'recurrent'       => ['boolean'],
            'date_specifique' => ['nullable', 'date'],
        ];
    }
}
