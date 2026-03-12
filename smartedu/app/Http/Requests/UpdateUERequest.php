<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('ue'));
    }

    public function rules(): array
    {
        return [
            'nom'         => ['sometimes', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'coefficient' => ['sometimes', 'numeric', 'min:0'],
            'credit'      => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
