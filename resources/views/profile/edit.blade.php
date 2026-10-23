@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Security &amp; Credentials</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Profile Settings</h1>
            <p class="text-secondary mb-0">Manage your personal details, access email, and authentication credentials.</p>
        </div>
        <div class="d-inline-flex align-items-center gap-2 text-success small fw-semibold bg-white px-3 py-2 rounded-3 border">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            256-Bit Encrypted Session
        </div>
    </div>

    <div class="row g-4">
        {{-- Profile Details --}}
        <div class="col-lg-7">
            <div class="surface-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.25rem; height: 2.25rem;">
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Personal Details</h2>
                </div>
                <p class="text-secondary small mb-4">Update your workspace identity and notification address.</p>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="name">Full Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="email">Email Address</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-icf-primary py-2 px-4 fw-bold" type="submit">
                        Save Profile Changes
                    </button>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="col-lg-5">
            <div class="surface-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.25rem; height: 2.25rem;">
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Authentication Password</h2>
                </div>
                <p class="text-secondary small mb-4">Ensure your account is protected with a robust password.</p>

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="current_password">Current Password</label>
                        <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" type="password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="password">New Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="password_confirmation">Confirm New Password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>

                    <button class="btn btn-icf-secondary w-100 py-2 fw-semibold" type="submit">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
