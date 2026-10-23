<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = $request->validateCredentials();

        $request->session()->put('login.otp_user_id', $user->id);
        $request->session()->put('login.remember', $request->boolean('remember'));

        return redirect()->route('login.otp');
    }

    public function showOtp(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $userId = $request->session()->get('login.otp_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::query()->find($userId);

        if (! $user) {
            $request->session()->forget(['login.otp_user_id', 'login.remember']);

            return redirect()->route('login');
        }

        return view('auth.otp', [
            'user' => $user,
        ]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $userId = $request->session()->get('login.otp_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::query()->find($userId);

        if (! $user) {
            $request->session()->forget(['login.otp_user_id', 'login.remember']);

            return redirect()->route('login');
        }

        $request->validate([
            'otp' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate('otp|'.$user->id.'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'otp' => "Too many verification attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $expectedOtp = (string) config('auth.login_otp', '847291');
        $providedOtp = preg_replace('/\s+/', '', (string) $request->input('otp'));

        if (! hash_equals($expectedOtp, $providedOtp)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'otp' => 'The security OTP code is incorrect. Only authorized administrators hold this key.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $remember = (bool) $request->session()->get('login.remember', false);
        $request->session()->forget(['login.otp_user_id', 'login.remember']);

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $request->session()->put('auth.otp_verified', true);

        return redirect()->intended(route('dashboard'))->with('success', 'Security verification completed. Welcome to your account.');
    }

    public function cancelOtp(Request $request): RedirectResponse
    {
        $request->session()->forget(['login.otp_user_id', 'login.remember']);

        return redirect()->route('login');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('status', 'You have been signed out.');
    }
}
