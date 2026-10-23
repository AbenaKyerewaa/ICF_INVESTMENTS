<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function validateCredentials(): User
    {
        $this->ensureIsNotRateLimited();

        $user = User::query()->where('email', $this->string('email'))->first();

        if (! $user || ! Hash::check($this->string('password'), $user->password) || $user->status !== 'active') {
            RateLimiter::hit($this->throttleKey(), 60);

            event(new Failed('web', $user, ['email' => $this->string('email')]));

            throw ValidationException::withMessages(['email' => 'The provided credentials do not match an active account.']);
        }

        RateLimiter::clear($this->throttleKey());

        return $user;
    }

    public function authenticate(): void
    {
        $user = $this->validateCredentials();

        Auth::login($user, $this->boolean('remember'));
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
