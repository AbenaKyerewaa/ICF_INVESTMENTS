<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('display_name') && ($this->filled('first_name') || $this->filled('last_name'))) {
            $this->merge([
                'display_name' => trim($this->string('first_name').' '.$this->string('last_name')),
            ]);
        }

        if (! $this->filled('bank_address') && ($this->filled('bank_street') || $this->filled('bank_city') || $this->filled('bank_country'))) {
            $parts = array_filter([
                $this->input('bank_street'),
                $this->input('bank_city'),
                $this->input('bank_state'),
                $this->input('bank_postal_code'),
                $this->input('bank_country'),
            ]);

            if (! empty($parts)) {
                $this->merge([
                    'bank_address' => implode(', ', $parts),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'account_identifier' => ['required', 'string', 'max:64'],
            'routing_number' => ['nullable', 'string', 'max:64'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'bank_address' => ['nullable', 'string', 'max:255'],
            'bank_street' => ['nullable', 'string', 'max:255'],
            'bank_city' => ['nullable', 'string', 'max:120'],
            'bank_state' => ['nullable', 'string', 'max:120'],
            'bank_postal_code' => ['nullable', 'string', 'max:60'],
            'bank_country' => ['nullable', 'string', 'max:120'],
        ];
    }
}
