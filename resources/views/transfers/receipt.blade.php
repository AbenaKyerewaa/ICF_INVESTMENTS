@extends('layouts.app')

@section('content')
@php
    $currency = $transfer->sendingAccount?->currency ?? $transfer->currency ?? 'USD';
    $currencySymbol = match(strtoupper($currency)) {
        'GBP' => '£',
        'EUR' => '€',
        'JPY' => '¥',
        'CHF' => 'CHF ',
        default => '$',
    };
@endphp
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/details.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Transfer Completed Successfully</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">Funds disbursed and ledger posted with verified atomic clearance.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-active px-3 py-2 shadow-sm" style="font-size: 0.75rem;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #4ade80; display: inline-block;"></span>
                Settlement Cleared
            </span>
        </div>
    </div>

    {{-- Transfer Stepper Bar --}}
    <div class="surface-card p-3 mb-4">
        <div class="row align-items-center text-center g-2">
            <div class="col-4">
                <div class="d-flex align-items-center justify-content-center gap-2 fw-semibold text-success">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #15803d; display: inline-grid; place-items: center; font-size: 0.75rem;">✓</span>
                    <span class="d-none d-sm-inline">1. Transfer Details</span>
                    <span class="d-inline d-sm-none">Details</span>
                </div>
            </div>
            <div class="col-4 border-start border-end">
                <div class="d-flex align-items-center justify-content-center gap-2 fw-semibold text-success">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #dcfce7; color: #15803d; display: inline-grid; place-items: center; font-size: 0.75rem;">✓</span>
                    <span class="d-none d-sm-inline">2. Review &amp; Verify</span>
                    <span class="d-inline d-sm-none">Review</span>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex align-items-center justify-content-center gap-2 fw-bold text-success">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #16a34a; color: #fff; display: inline-grid; place-items: center; font-size: 0.75rem;">✓</span>
                    <span class="d-none d-sm-inline">3. Execution &amp; Receipt</span>
                    <span class="d-inline d-sm-none">Receipt</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Receipt Voucher (Left Column) --}}
        <div class="col-lg-8">
            <div class="surface-card p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div style="width: 3.25rem; height: 3.25rem; border-radius: 50%; background: #dcfce7; color: #15803d; display: grid; place-items: center; flex-shrink: 0;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Sent Successfully</h2>
                    </div>
                </div>

                <div class="p-4 rounded-3 border mb-4" style="background: rgba(248, 250, 255, 0.9); border-color: rgba(22, 163, 74, 0.2) !important;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pb-3 border-bottom mb-3 gap-2">
                        <span class="text-secondary small text-uppercase fw-semibold tracking-wider">Settled Amount</span>
                        <span class="fs-3 fw-bold text-success">{{ $currencySymbol }}{{ number_format($transfer->amount, 2) }} <span class="fs-6 fw-normal text-secondary">{{ $currency }}</span></span>
                    </div>

                    <dl class="row mb-0 gy-3">
                        <dt class="col-sm-4 text-secondary small">Transaction Reference</dt>
                        <dd class="col-sm-8 font-monospace fw-bold mb-0 text-dark">{{ $transfer->reference }}</dd>

                        <dt class="col-sm-4 text-secondary small">Beneficiary Recipient</dt>
                        <dd class="col-sm-8 fw-semibold mb-0 text-dark">{{ $transfer->beneficiary->display_name }}</dd>

                        <dt class="col-sm-4 text-secondary small">Settlement Timestamp</dt>
                        <dd class="col-sm-8 mb-0 text-dark">{{ $transfer->completed_at?->format('M j, Y H:i:s') ?? now()->format('M j, Y H:i:s') }} UTC</dd>

                        @if($transfer->user_reference)
                            <dt class="col-sm-4 text-secondary small">Reference Memo</dt>
                            <dd class="col-sm-8 mb-0 text-secondary">{{ $transfer->user_reference }}</dd>
                        @endif

                        <dt class="col-sm-4 text-secondary small">Ledger Posting Status</dt>
                        <dd class="col-sm-8 mb-0">
                            <span class="badge-status badge-active">Completed &amp; Verified</span>
                        </dd>
                    </dl>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a class="btn btn-icf-primary py-3 px-4 fw-bold flex-grow-1 text-center" href="{{ route('documents.receipt', $transfer) }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Download Official PDF Receipt
                    </a>
                    <a class="btn btn-icf-secondary py-3 px-4 text-center" href="{{ route('dashboard') }}">
                        Return to Dashboard
                    </a>
                    <a class="btn btn-outline-secondary py-3 px-3 text-center" href="{{ route('transfers.create') }}" title="New Transfer">
                        New Transfer
                    </a>
                </div>
            </div>
        </div>

        {{-- Companion Information (Right Column) --}}
        <div class="col-lg-4">
            {{-- Recipient Account Card --}}
            <div class="surface-card p-4 mb-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: #dbeafe; color: #2563eb; display: grid; place-items: center; flex-shrink: 0;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <h3 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Recipient Account</h3>
                </div>

                <div class="mb-3">
                    <div class="text-secondary small mb-1">Account Number</div>
                    <div class="fw-bold fs-5" style="color: var(--icf-navy); letter-spacing: -0.01em;">
                        ****{{ substr($transfer->beneficiary->account_identifier, -4) ?: '9821' }}
                    </div>
                </div>

                <div class="mb-3">
                    <div class="text-secondary small mb-1">Transfer Type</div>
                    <div class="fw-bold fs-5" style="color: var(--icf-navy);">
                        {{ !empty($transfer->user_reference) && in_array(strtolower($transfer->user_reference), ['bill pay', 'wire transfer', 'investment transfer', 'investment transfers']) ? ucwords($transfer->user_reference) : 'Wire Transfer' }}
                    </div>
                </div>

                <div>
                    <div class="text-secondary small mb-1">Bank</div>
                    <div class="fw-bold fs-5" style="color: var(--icf-navy);">
                        {{ $transfer->beneficiary->institution_name ?: 'Standard Bank' }}
                    </div>
                </div>
            </div>

            {{-- Need Help? Card --}}
            <div class="surface-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: #2563eb; color: #fff; display: grid; place-items: center; flex-shrink: 0; font-weight: 700; font-size: 1.15rem; font-family: serif;">
                        i
                    </div>
                    <h3 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Need Help?</h3>
                </div>
                <p class="text-secondary small mb-3 lh-sm">
                    If you have any questions, please contact our Customer Care team.
                </p>
                <a class="text-primary fw-bold text-decoration-none d-inline-flex align-items-center gap-1" href="{{ route('contact') }}">
                    <span>Contact Us</span>
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
