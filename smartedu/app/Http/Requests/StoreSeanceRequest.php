<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Seance::class);
    }

    public function rules(): array
    {
        return [
            'cours_id'        => ['required', 'exists:cours,id'],
            'promotion_id'    => ['required', 'exists:promotions,id'],
            'salle'           => ['nullable', 'string', 'max:50'],
            'jour'            => ['required', 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi'],
            'heure_debut'     => ['required', 'date_format:H:i'],
            'heure_fin'       => ['required', 'date_format:H:i', 'after:heure_debut'],
            'type'            => ['required', 'in:cm,td,tp'],
            'recurrent'       => ['required', 'boolean'],
            'date_specifique' => ['required_if:recurrent,false', 'nullable', 'date'],
        ];
    }
}
