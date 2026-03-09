<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdministrateurRequest extends FormRequest
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
            'utilisateur_id' => ['required', 'integer', 'exists:users,id', Rule::unique('administrateurs', 'utilisateur_id')->ignore($this->route('administrateur'))],
        ];
    }
}
