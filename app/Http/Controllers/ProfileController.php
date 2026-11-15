<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\AccountNotification;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $account = auth()->user()->accounts()->where('account_reference', 'ICF-4821')->first()
            ?? auth()->user()->accounts()->where('status', 'active')->first()
            ?? auth()->user()->accounts()->first();
        $account?->sync2024Ledger();

        return view('profile.edit', compact('account'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        session()->flash('_form_type', 'profile');
        $this->verifySecurityOtp($request->input('otp'), $user->id, 'profile_otp');

        $fields = array_filter(
            $request->safe()->only(['name', 'email', 'phone']),
            fn ($value) => $value !== null
        );
        $user->update($fields);

        AuditLog::query()->create([
            'actor_user_id' => $user->id,
            'action' => 'profile.updated',
            'target_type' => 'user',
            'target_id' => $user->id,
            'metadata' => [
                'updated_fields' => array_keys($fields),
                'verified_via_otp' => true,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile details updated successfully with OTP verification.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        session()->flash('_form_type', 'password');
        $this->verifySecurityOtp($request->input('otp'), $user->id, 'password_otp');

        $user->update($request->safe()->only('password'));

        AuditLog::query()->create([
            'actor_user_id' => $user->id,
            'action' => 'profile.password.updated',
            'target_type' => 'user',
            'target_id' => $user->id,
            'metadata' => [
                'status' => 'password_updated',
                'verified_via_otp' => true,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        AccountNotification::query()->create([
            'user_id' => $user->id,
            'type' => 'security.password_updated',
            'title' => 'Password Changed',
            'message' => 'Your account password was successfully updated with verified OTP authorization.',
            'data' => [],
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully with OTP verification.');
    }

    private function verifySecurityOtp(mixed $otpInput, int $userId, string $actionType): void
    {
        $throttleKey = Str::transliterate($actionType.'|'.$userId.'|'.request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'otp' => "Too many verification attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $expectedOtp = (string) config('auth.login_otp', '889201');
        $providedOtp = preg_replace('/\s+/', '', (string) $otpInput);

        if (! hash_equals($expectedOtp, $providedOtp)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'otp' => 'The security OTP code is incorrect. Please enter the valid 6-digit master key.',
            ]);
        }

        RateLimiter::clear($throttleKey);
    }
}
