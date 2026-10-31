@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: radial-gradient(circle at 80% 15%, rgba(13, 35, 68, 0.55) 0%, rgba(7, 15, 30, 0.85) 100%), url('/images/profile.jpg') center right / cover no-repeat fixed;">
<div class="page-container">
    @php
        $primaryAccount = $account ?? (auth()->user()->accounts()->where('status', 'active')->first() ?? auth()->user()->accounts()->first());
    @endphp

    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.2) !important;">
        <div>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill small fw-bold text-uppercase mb-2" style="background: rgba(56, 189, 248, 0.14); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc; font-size: 0.7rem; letter-spacing: 0.08em;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Client Security &amp; Identity Center
            </span>
            <h1 class="h2 fw-bold mb-1" style="color: #ffffff !important; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.45);">Profile Settings</h1>
            <p class="mb-0 fw-medium" style="color: rgba(255, 255, 255, 0.86) !important; text-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);">Manage your personal details, contact phone, and authentication credentials.</p>
        </div>
        @if($primaryAccount)
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(74, 222, 128, 0.35); backdrop-filter: blur(8px);">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 8px #4ade80; display: inline-block;"></span>
                <span class="small fw-semibold text-white">{{ ucfirst($primaryAccount->status) }} Institutional Profile</span>
            </div>
        @endif
    </div>

    {{-- Personal Details Banner Card showcasing /images/security.jpg --}}
    <div class="rounded-4 overflow-hidden mb-4 shadow-lg position-relative" style="border: 1px solid rgba(125, 211, 252, 0.25); background: linear-gradient(95deg, rgba(6, 17, 36, 0.94) 0%, rgba(8, 25, 52, 0.84) 48%, rgba(8, 25, 52, 0.22) 100%), url('/images/security.jpg') right center / cover no-repeat;">
        <div class="p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if(auth()->user()->avatarUrl())
                            <div class="rounded-circle shadow overflow-hidden flex-shrink-0" style="width: 4.25rem; height: 4.25rem; border: 2.5px solid rgba(125, 211, 252, 0.75);">
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow" style="width: 3.35rem; height: 3.35rem; background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%); border: 2px solid rgba(125, 211, 252, 0.55); font-size: 1.2rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h2 class="h5 fw-bold mb-0 text-white">Personal Details</h2>
                                <span class="badge rounded-pill px-2 py-1" style="background: rgba(56, 189, 248, 0.18); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.35); font-size: 0.68rem;">KYC VERIFIED</span>
                            </div>
                            <span class="small" style="color: rgba(226, 232, 240, 0.85);">Verified institutional account credentials and client profile.</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(15, 29, 54, 0.78); border: 1px solid rgba(255, 255, 255, 0.14); backdrop-filter: blur(8px);">
                                <div class="small text-uppercase fw-semibold" style="color: #93c5fd; letter-spacing: .06em; font-size: 0.7rem;">Customer Name</div>
                                <div class="fw-bold fs-6 mt-1 text-white text-truncate">{{ auth()->user()->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(15, 29, 54, 0.78); border: 1px solid rgba(255, 255, 255, 0.14); backdrop-filter: blur(8px);">
                                <div class="small text-uppercase fw-semibold" style="color: #93c5fd; letter-spacing: .06em; font-size: 0.7rem;">Account Type</div>
                                <div class="fw-bold fs-6 mt-1 text-white text-truncate">
                                    {{ $primaryAccount ? $primaryAccount->name : 'Private Wealth Portfolio' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(15, 29, 54, 0.78); border: 1px solid rgba(255, 255, 255, 0.14); backdrop-filter: blur(8px);">
                                <div class="small text-uppercase fw-semibold" style="color: #93c5fd; letter-spacing: .06em; font-size: 0.7rem;">Account Number</div>
                                <div class="font-monospace fw-bold fs-6 mt-1 text-truncate" style="color: #38bdf8;">
                                    {{ $primaryAccount ? $primaryAccount->account_reference : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 align-items-stretch">
        {{-- Profile Changes --}}
        <div class="col-lg-7 d-flex">
            <div class="rounded-4 p-4 p-lg-5 w-100 d-flex flex-column justify-content-between shadow-lg" style="background: rgba(10, 24, 48, 0.82); backdrop-filter: blur(14px); border: 1px solid rgba(125, 211, 252, 0.22);">
                <div>
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.12) !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 2.6rem; height: 2.6rem; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                                <svg width="18" height="18" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </div>
                            <div>
                                <h2 class="h5 fw-bold mb-0 text-white">Profile Changes</h2>
                                <p class="small mb-0" style="color: rgba(203, 213, 225, 0.85);">Update your contact phone and notification email address.</p>
                            </div>
                        </div>
                    </div>

                    <form id="profile-update-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="otp" id="profile_otp_hidden" value="">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.05em; color: #93c5fd; font-size: 0.74rem;" for="phone">Phone Number</label>
                            <input class="form-control py-2 text-white @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Enter phone number (e.g. +1 555-019-2834)" style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.18);">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.05em; color: #93c5fd; font-size: 0.74rem;" for="email">Email Address</label>
                            <input class="form-control py-2 text-white @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Enter email address (e.g. name@example.com)" required style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.18);">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @error('otp')
                            @if(old('_form_type', session('_form_type')) !== 'password')
                                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3" style="background: rgba(220, 38, 38, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5;">
                                    <strong>OTP Error:</strong> {{ $message }}
                                </div>
                            @endif
                        @enderror

                        <div class="p-3 rounded-3 mb-4 d-flex align-items-start gap-3" style="background: rgba(14, 34, 68, 0.65); border: 1px solid rgba(56, 189, 248, 0.28);">
                            <svg class="flex-shrink-0 mt-1" width="18" height="18" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <div class="small" style="color: #cbd5e1; line-height: 1.55;">
                                <strong class="text-white">Institutional Security Notice:</strong> Submitting changes triggers an instant 6-digit OTP verification prompt before confirmation.
                            </div>
                        </div>

                        <button class="btn btn-icf-primary py-2 px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2" type="button" onclick="triggerOtpModal('profile-update-form', 'profile_otp_hidden', 'Profile Details Update')">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Save Profile Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="col-lg-5 d-flex">
            <div class="rounded-4 p-4 p-lg-5 w-100 d-flex flex-column justify-content-between shadow-lg" style="background: rgba(10, 24, 48, 0.82); backdrop-filter: blur(14px); border: 1px solid rgba(125, 211, 252, 0.22);">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.12) !important;">
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 2.6rem; height: 2.6rem; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                            <svg width="18" height="18" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-0 text-white">Authentication Password</h2>
                            <p class="small mb-0" style="color: rgba(203, 213, 225, 0.85);">Ensure your account is protected with a robust password.</p>
                        </div>
                    </div>

                    <form id="password-update-form" method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="otp" id="password_otp_hidden" value="">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.05em; color: #93c5fd; font-size: 0.74rem;" for="current_password">Current Password</label>
                            <input class="form-control py-2 text-white @error('current_password') is-invalid @enderror" id="current_password" name="current_password" type="password" placeholder="••••••••••••" required style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.18);">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.05em; color: #93c5fd; font-size: 0.74rem;" for="password">New Password</label>
                            <input class="form-control py-2 text-white @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Minimum 8 characters" required style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.18);">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.05em; color: #93c5fd; font-size: 0.74rem;" for="password_confirmation">Confirm New Password</label>
                            <input class="form-control py-2 text-white" id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-enter new password" required style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.18);">
                        </div>

                        @error('otp')
                            @if(old('_form_type', session('_form_type')) === 'password')
                                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3" style="background: rgba(220, 38, 38, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5;">
                                    <strong>OTP Error:</strong> {{ $message }}
                                </div>
                            @endif
                        @enderror

                        <button class="btn btn-icf-secondary w-100 py-2 fw-semibold shadow-sm d-inline-flex align-items-center justify-content-center gap-2" type="button" onclick="triggerOtpModal('password-update-form', 'password_otp_hidden', 'Authentication Password Update')" style="background: rgba(255, 255, 255, 0.12); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.28);">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- Interactive Security Access Key (OTP) Modal --}}
<div class="modal fade" id="securityOtpModal" tabindex="-1" aria-labelledby="securityOtpModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content rounded-4 border shadow-2xl" style="background: rgba(7, 19, 41, 0.98); backdrop-filter: blur(20px); border-color: rgba(56, 189, 248, 0.35); color: #fff;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 2.85rem; height: 2.85rem; background: rgba(56, 189, 248, 0.15); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                        <svg width="20" height="20" fill="none" stroke="#38bdf8" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h2 class="h5 fw-bold mb-0 text-white" id="securityOtpModalLabel">Security Access Key</h2>
                        <span class="small" id="otpModalActionSubtitle" style="color: #93c5fd; font-size: 0.76rem;">Identity Verification Gate</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 text-center">
                <span class="badge rounded-pill px-3 py-1 mb-3" style="background: rgba(250, 204, 21, 0.15); color: #fde047; border: 1px solid rgba(250, 204, 21, 0.3); font-size: 0.72rem; letter-spacing: 0.06em;">
                    ✦ TWO-STEP AUTHORIZATION REQUIRED
                </span>
                <p class="small text-white-50 mb-4" style="line-height: 1.6;">
                    Please enter the 6-digit constant master verification code to authorize and commit your security changes.
                </p>

                <div class="mb-3">
                    <input 
                        type="text" 
                        id="modal_otp_input" 
                        class="form-control text-center font-monospace py-2 text-white" 
                        inputmode="numeric" 
                        pattern="[0-9]*" 
                        maxlength="6" 
                        placeholder="••••••" 
                        autocomplete="one-time-code"
                        style="background: rgba(10, 22, 44, 0.95); border: 2px solid rgba(250, 204, 21, 0.5); font-size: 2rem; letter-spacing: 0.45em; font-weight: 700; color: #fff;"
                    >
                    <div id="modal_otp_error" class="text-danger small mt-2 d-none fw-semibold">
                        Please enter a valid 6-digit verification code.
                    </div>
                </div>

                <div class="p-2 px-3 rounded-3 mt-3 d-flex align-items-center justify-content-between small" style="background: rgba(15, 30, 56, 0.75); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <span class="text-white-50" style="font-size: 0.75rem;">Account Authorized:</span>
                    <strong class="text-white font-monospace" style="font-size: 0.78rem;">{{ auth()->user()->email }}</strong>
                </div>
            </div>

            <div class="modal-footer border-top px-4 py-3 d-flex justify-content-between" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                <button type="button" class="btn btn-icf-secondary py-2 px-3 fw-semibold small text-white border-white-50" data-bs-dismiss="modal" style="background: transparent;">
                    Cancel
                </button>
                <button type="button" class="btn btn-icf-primary py-2 px-4 fw-bold small shadow" onclick="submitAuthorizedForm()">
                    Authorize &amp; Proceed →
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeTargetFormId = null;
    let activeTargetHiddenInputId = null;

    function triggerOtpModal(formId, hiddenInputId, actionLabel) {
        const form = document.getElementById(formId);
        if (!form) return;

        // Check HTML5 validity of the form inputs first (e.g. required fields, email format)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        activeTargetFormId = formId;
        activeTargetHiddenInputId = hiddenInputId;

        document.getElementById('otpModalActionSubtitle').innerText = actionLabel || 'Identity Verification Gate';
        const modalInput = document.getElementById('modal_otp_input');
        modalInput.value = '';
        document.getElementById('modal_otp_error').classList.add('d-none');

        const otpModal = new bootstrap.Modal(document.getElementById('securityOtpModal'));
        otpModal.show();

        setTimeout(() => {
            modalInput.focus();
        }, 400);
    }

    function submitAuthorizedForm() {
        const modalInput = document.getElementById('modal_otp_input');
        const code = (modalInput.value || '').trim();

        if (code.length < 6) {
            const errEl = document.getElementById('modal_otp_error');
            errEl.innerText = 'Please enter a valid 6-digit security OTP.';
            errEl.classList.remove('d-none');
            modalInput.focus();
            return;
        }

        if (activeTargetHiddenInputId && document.getElementById(activeTargetHiddenInputId)) {
            document.getElementById(activeTargetHiddenInputId).value = code;
        }

        if (activeTargetFormId && document.getElementById(activeTargetFormId)) {
            document.getElementById(activeTargetFormId).submit();
        }
    }

    // Allow pressing "Enter" directly inside the OTP input modal to submit
    document.getElementById('modal_otp_input')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitAuthorizedForm();
        }
    });
</script>
@endsection
