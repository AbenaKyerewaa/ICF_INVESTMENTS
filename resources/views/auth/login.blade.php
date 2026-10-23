@extends('layouts.app')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="brand-mark mx-auto mb-3" style="width: 2.75rem; height: 2.75rem; font-size: 0.9rem;">ICF</div>
                <span class="eyebrow eyebrow-gold mb-2">Institutional Client Portal</span>
                <h1 class="h3 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Client Access</h1>
                <p class="text-secondary small mb-0">Sign in to your private wealth management workspace.</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email Address</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', 'maya.bennett@icf-investment.demo') }}" autocomplete="email" required autofocus placeholder="name@domain.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold mb-0" for="password">Password</label>
                        <span class="text-muted small" style="font-size: 0.75rem;">Default: password</span>
                    </div>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" value="password" autocomplete="current-password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" checked>
                    <label class="form-check-label small text-secondary" for="remember">Keep this session signed in</label>
                </div>
                <button class="btn btn-icf-primary w-100 py-2 fw-bold" type="submit">
                    Sign In
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="mt-4 p-3 rounded-3 bg-light border small text-secondary">
                <div class="fw-semibold text-dark mb-1 d-flex align-items-center gap-1">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Authorized Workspaces:</span>
                </div>
                <div class="text-muted mb-1">Client: <code class="text-dark">maya.bennett@icf-investment.demo</code></div>
                <div class="text-muted">Administrator: <code class="text-dark">admin@icf.test</code></div>
            </div>
        </div>
    </div>
@endsection
