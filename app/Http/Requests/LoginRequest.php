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

        $rawEmail = trim((string) $this->input('email'));
        $lowerEmail = Str::lower($rawEmail);

        // Find user by direct email or domain alias (e.g. @icf-investment.demo <-> @icf.test)
        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$lowerEmail])
            ->first();

        if (! $user) {
            if (str_ends_with($lowerEmail, '@icf-investment.demo')) {
                $alternateEmail = str_replace('@icf-investment.demo', '@icf.test', $lowerEmail);
                $user = User::query()->whereRaw('LOWER(email) = ?', [$alternateEmail])->first();
            } elseif (str_ends_with($lowerEmail, '@icf.test')) {
                $alternateEmail = str_replace('@icf.test', '@icf-investment.demo', $lowerEmail);
                $user = User::query()->whereRaw('LOWER(email) = ?', [$alternateEmail])->first();
            }
        }

        if (! $user || ! Hash::check((string) $this->input('password'), $user->password) || $user->status !== 'active') {
            RateLimiter::hit($this->throttleKey(), 60);

            event(new Failed('web', $user, ['email' => $rawEmail]));

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
        return Str::transliterate(Str::lower(trim((string) $this->input('email'))).'|'.$this->ip());
    }
}
