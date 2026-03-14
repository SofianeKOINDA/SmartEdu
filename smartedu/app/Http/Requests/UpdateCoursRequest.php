<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('cours'));
    }

    public function rules(): array
    {
        return [
            'enseignant_id'  => ['nullable', 'exists:enseignants,id'],
            'intitule'       => ['sometimes', 'string', 'max:255'],
            'coefficient'    => ['sometimes', 'numeric', 'min:0'],
            'volume_horaire' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
