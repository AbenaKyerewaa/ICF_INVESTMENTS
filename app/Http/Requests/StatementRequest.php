<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['from' => ['required', 'date'], 'to' => ['required', 'date', 'after_or_equal:from']];
    }
}
