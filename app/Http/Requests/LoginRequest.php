<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return ['email' => ['required', 'string', 'email'], 'password' => ['required', 'string'], 'remember' => ['nullable', 'boolean']];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt([...$this->safe()->only(['email', 'password']), 'status' => 'active'], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(), 60);
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match an active account.']);
        }

        RateLimiter::clear($this->throttleKey());
    }

    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        throw ValidationException::withMessages(['email' => 'Too many login attempts. Please try again later.']);
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')->toString()).'|'.$this->ip());
    }
}
