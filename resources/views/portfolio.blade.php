@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <div class="mb-2">
                <span class="eyebrow eyebrow-gold">✦ Credit Card &amp; Account Portfolio</span>
            </div>
            <h1 class="h2 fw-bold mb-1" style="color: var(--icf-navy);">Portfolio</h1>
            <p class="text-secondary mb-0">Your linked credit card and investment account details.</p>
        </div>
        @if($account)
            <a class="btn btn-icf-primary" href="{{ route('accounts.show', $account) }}">
                View Full Ledger
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        @endif
    </div>

    @if($account)
        <div class="row g-4">
            {{-- Credit Card Visual --}}
            <div class="col-lg-5">
                <div class="balance-card h-100 d-flex flex-column justify-content-between position-relative" style="min-height: 220px;">
                    <div class="balance-glow"></div>
                    <div style="position: relative; z-index: 1;">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <div style="font-size: 1.3rem; font-weight: 800; letter-spacing: .15em; color: rgba(255,255,255,.9);">ICF</div>
                                <div style="font-size: .72rem; color: rgba(255,255,255,.5); letter-spacing:.08em;">INVESTMENT BANK</div>
                            </div>
                            <svg width="38" height="38" viewBox="0 0 38 38" fill="none">
                                <circle cx="15" cy="19" r="13" fill="rgba(255,255,255,0.18)"/>
                                <circle cx="23" cy="19" r="13" fill="rgba(255,255,255,0.10)"/>
                            </svg>
                        </div>
                        <div style="font-family: monospace; font-size: 1.05rem; letter-spacing: .2em; color: rgba(255,255,255,.85); margin-bottom: 1.2rem;">
                            •••• •••• •••• {{ substr($account->account_reference, -4) }}
                        </div>
                        <div class="d-flex gap-4">
                            <div>
                                <div style="font-size: .62rem; color: rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.06em;">Account Holder</div>
                                <div style="font-size: .82rem; font-weight: 600; color: #fff;">{{ auth()->user()->name }}</div>
                            </div>
                            <div>
                                <div style="font-size: .62rem; color: rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.06em;">Status</div>
                                <div style="font-size: .82rem; font-weight: 600; color: #4ade80;">{{ ucfirst($account->status) }}</div>
                            </div>
                        </div>
                    </div>
                    <div style="position: relative; z-index: 1; margin-top: 1.4rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,.12);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: .62rem; color: rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.06em;">Available Balance</div>
                                <div style="font-size: 1.45rem; font-weight: 700; color: #fff;">${{ number_format($account->balance, 2) }} <span style="font-size:.8rem; font-weight:400; color:rgba(255,255,255,.5);">{{ $account->currency }}</span></div>
                            </div>
                            <a href="{{ route('accounts.show', $account) }}" style="font-size:.75rem; color: rgba(255,255,255,.6); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem;">
                                View ledger
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Details --}}
            <div class="col-lg-7">
                <div class="surface-card p-4 h-100">
                    <h2 class="h6 fw-bold mb-4" style="color: var(--icf-navy);">Account Details</h2>
                    <dl class="row g-3 mb-0">
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Account Name</dt>
                            <dd class="fw-semibold mb-0">{{ $account->name }}</dd>
                        </div>
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Reference</dt>
                            <dd class="fw-semibold font-monospace mb-0">{{ $account->account_reference }}</dd>
                        </div>
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Currency</dt>
                            <dd class="fw-semibold mb-0">{{ $account->currency }}</dd>
                        </div>
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Account Status</dt>
                            <dd class="mb-0">
                                <span class="badge-status badge-active" style="background: rgba(34,197,94,.15); color: #86efac; border: 1px solid rgba(34,197,94,.3);">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#4ade80;display:inline-block;"></span>
                                    {{ ucfirst($account->status) }}
                                </span>
                            </dd>
                        </div>
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Available Balance</dt>
                            <dd class="fw-bold text-success mb-0 fs-5">${{ number_format($account->balance, 2) }}</dd>
                        </div>
                        <div class="col-sm-6">
                            <dt class="small text-secondary fw-normal mb-1">Account Holder</dt>
                            <dd class="fw-semibold mb-0">{{ auth()->user()->name }}</dd>
                        </div>
                    </dl>
                    <div class="mt-4 pt-3 border-top d-flex gap-2">
                        <a class="btn btn-sm btn-icf-primary" href="{{ route('transfers.create') }}">Transfer Funds</a>
                        <a class="btn btn-sm btn-icf-secondary" href="{{ route('accounts.show', $account) }}">View Full Ledger</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="surface-card p-5 text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                <svg width="24" height="24" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <h2 class="h5 fw-bold">No active account assigned</h2>
            <p class="text-secondary mb-0">An administrator can assign an active investment account before portfolio details become available.</p>
        </div>
    @endif
</div>
@endsection
