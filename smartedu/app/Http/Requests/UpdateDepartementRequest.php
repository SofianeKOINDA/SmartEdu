<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('departement'));
    }

    public function rules(): array
    {
        return [
            'faculte_id' => ['sometimes', 'exists:facultes,id'],
            'nom'        => ['sometimes', 'string', 'max:255'],
            'code'       => ['nullable', 'string', 'max:20'],
        ];
    }
}
