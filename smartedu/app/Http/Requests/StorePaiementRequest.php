<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'etudiant_matricule' => ['required', 'string', 'exists:etudiants,matricule'],
            'montant'            => ['required', 'numeric', 'min:0'],
            'date'               => ['required', 'date'],
            'statut'             => ['required', 'in:en_attente,valide,refuse,rembourse'],
            'methode'            => ['required', 'in:especes,virement,carte,mobile_money'],
            'type'               => ['required', 'in:scolarite,inscription'],
        ];
    }
    public function messages()
    {
        return [
            'etudiant_matricule.required' => 'Le matricule de l\'étudiant est requis.',
            'montant.required' => 'Le montant est requis.',
            'date.required' => 'La date est requise.',
            'statut.required' => 'Le statut est requis.',
            'methode.required' => 'La méthode de paiement est requise.',
            'type.required' => 'Le type de paiement est requis.',
        ];
    }
}
