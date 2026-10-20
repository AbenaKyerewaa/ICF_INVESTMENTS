<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['display_name' => ['required', 'string', 'max:255'], 'account_identifier' => ['required', 'string', 'max:64'], 'institution_name' => ['nullable', 'string', 'max:255']];
    }
}
