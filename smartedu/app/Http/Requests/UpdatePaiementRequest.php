<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['sometimes', 'string', 'exists:etudiants,matricule'],
            'montant'            => ['sometimes', 'numeric', 'min:0'],
            'date'               => ['sometimes', 'date'],
            'statut'             => ['sometimes', 'in:en_attente,valide,refuse,rembourse'],
            'methode'            => ['sometimes', 'in:especes,virement,carte,mobile_money'],
            'type'               => ['sometimes', 'in:scolarite,inscription'],
        ];
    }
}
