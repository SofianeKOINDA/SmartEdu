<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Cours::class);
    }

    public function rules(): array
    {
        return [
            'ue_id'          => ['required', 'exists:ues,id'],
            'enseignant_id'  => ['nullable', 'exists:enseignants,id'],
            'intitule'       => ['required', 'string', 'max:255'],
            'code'           => ['nullable', 'string', 'max:20'],
            'coefficient'    => ['required', 'numeric', 'min:0'],
            'volume_horaire' => ['required', 'integer', 'min:0'],
        ];
    }
}
