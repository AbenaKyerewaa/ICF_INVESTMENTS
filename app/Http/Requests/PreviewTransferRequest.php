<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreviewTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['account_id' => ['required', 'integer'], 'beneficiary_id' => ['required', 'integer'], 'amount' => ['required', 'decimal:0,2', 'gt:0'], 'reference' => ['nullable', 'string', 'max:140']];
    }
}
