<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'etudiant_id' => ['required', 'integer', 'exists:etudiants,id'],
            'cours_id' => [
                'nullable',
                Rule::requiredIf(fn () => $this->input('type') === 'inscription_cours'),
                Rule::prohibitedIf(fn () => $this->input('type') === 'scolarite'),
                'integer',
                'exists:cours,id',
            ],
            'montant' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'statut' => ['required', 'in:en_attente,valide,refuse,rembourse'],
            'methode' => ['required', 'in:especes,virement,carte,mobile_money'],
            'type' => ['required', 'in:scolarite,inscription_cours'],
        ];
    }
}
