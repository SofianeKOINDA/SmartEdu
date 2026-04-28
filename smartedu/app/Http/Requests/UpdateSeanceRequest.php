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
    public function messages(): array
    {
        return [
            'salle.string' => 'Le champ salle doit être une chaîne de caractères.',
            'salle.max' => 'Le champ salle ne doit pas dépasser 50 caractères.',
            'jour.in' => 'Le champ jour doit être l\'un des suivants : lundi, mardi, mercredi, jeudi, vendredi, samedi.',
            'heure_debut.date_format' => 'Le champ heure de début doit être au format HH:MM.',
            'heure_fin.date_format' => 'Le champ heure de fin doit être au format HH:MM.',
            'type.in' => 'Le champ type doit être l\'un des suivants : cm, td, tp.',
            'recurrent.boolean' => 'Le champ récurrent doit être un booléen.',
            'date_specifique.date' => 'Le champ date spécifique doit être une date valide.',
        ];
    }
}
