@extends('layouts.app')

@section('content')
    <div class="page-container">
        <div class="surface-card auth-card">
            <span class="eyebrow">Client Portal</span>
            <h1 class="h2 fw-bold mt-3" style="color: var(--icf-navy);">Welcome back</h1>
            <p class="text-secondary">Sign in to access your ICF Investment workspace.</p>
            <form method="POST" action="{{ route('login.store') }}" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email address</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', 'maya.bennett@icf-investment.demo') }}" autocomplete="email" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" value="password" autocomplete="current-password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" checked>
                    <label class="form-check-label" for="remember">Remember me on this device</label>
                </div>
                <button class="btn btn-icf-primary w-100 py-2 fw-bold" type="submit">Sign In →</button>
            </form>
            <div class="mt-4 p-3 rounded-3 bg-light border small text-secondary">
                <div class="fw-semibold text-dark mb-1">Access Credentials:</div>
                <div>Customer: <code>maya.bennett@icf-investment.demo</code> / <code>password</code></div>
                <div>Administrator: <code>admin@icf.test</code> / <code>password</code></div>
            </div>
        </div>
    </div>
@endsection
