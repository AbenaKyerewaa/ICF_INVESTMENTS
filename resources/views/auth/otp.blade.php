@extends('layouts.app')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="brand-mark mx-auto mb-3" style="width: 2.75rem; height: 2.75rem; font-size: 0.9rem;">ICF</div>
                <span class="eyebrow eyebrow-gold mb-2">Two-Step Security Gate</span>
                <h1 class="h3 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Security Access Key</h1>
                <p class="text-secondary small mb-0">Insert the constant master verification code to unlock this account.</p>
            </div>

            {{-- Verified User Identity Pill --}}
            <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-3 bg-light border mb-4">
                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--icf-blue); color: #fff; display: grid; place-items: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span class="small fw-semibold text-dark text-truncate">{{ $user->email }}</span>
                </div>
                <span class="badge-status badge-active flex-shrink-0" style="font-size: 0.65rem;">
                    Verified
                </span>
            </div>

            <form method="POST" action="{{ route('login.otp.verify') }}">
                @csrf
                <div class="mb-4 text-center">
                    <label class="form-label fw-semibold text-center d-block mb-2" for="otp">Enter 6-Digit Constant Security OTP</label>
                    <input 
                        class="form-control text-center font-monospace @error('otp') is-invalid @enderror" 
                        id="otp" 
                        name="otp" 
                        type="text" 
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        placeholder="••••••"
                        autocomplete="one-time-code"
                        style="font-size: 1.85rem; letter-spacing: 0.45em; font-weight: 700; padding: 0.65rem; border-color: #cbd5e1;"
                        required 
                        autofocus
                    >
                    @error('otp')
                        <div class="invalid-feedback text-center mt-2 d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-center text-muted small mt-2">
                        Only the administrator holds this constant key.
                    </div>
                </div>

                <button class="btn btn-icf-primary w-100 py-3 fw-bold" type="submit">
                    Verify &amp; Open Account
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center">
                <form method="POST" action="{{ route('login.otp.cancel') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none small text-secondary p-0">
                        ← Sign in with a different account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
