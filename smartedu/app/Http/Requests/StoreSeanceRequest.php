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
    public function messages(): array
    {
        return [
            'cours_id.required' => 'Le champ cours est obligatoire.',
            'cours_id.exists' => 'Le cours sélectionné est invalide.',
            'promotion_id.required' => 'Le champ promotion est obligatoire.',
            'promotion_id.exists' => 'La promotion sélectionnée est invalide.',
            'salle.string' => 'Le champ salle doit être une chaîne de caractères.',
            'salle.max' => 'Le champ salle ne doit pas dépasser 50 caractères.',
            'jour.required' => 'Le champ jour est obligatoire.',
            'jour.in' => 'Le champ jour doit être l\'un des suivants : lundi, mardi, mercredi, jeudi, vendredi, samedi.',
            'heure_debut.required' => 'Le champ heure de début est obligatoire.',
            'heure_debut.date_format' => 'Le champ heure de début doit être au format HH:MM.',
            'heure_fin.required' => 'Le champ heure de fin est obligatoire.',
            'heure_fin.date_format' => 'Le champ heure de fin doit être au format HH:MM.',
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
            'type.required' => 'Le champ type est obligatoire.',
            'type.in' => 'Le champ type doit être l\'un des suivants : cm, td, tp.',
            'recurrent.required' => 'Le champ récurrent est obligatoire.',
            'recurrent.boolean' => 'Le champ récurrent doit être un booléen.',
            'date_specifique.required_if' => 'Le champ date spécifique est obligatoire lorsque la séance n\'est pas récurrente.',
            'date_specifique.date' => 'Le champ date spécifique doit être une date valide.',
        ];
    }
}
