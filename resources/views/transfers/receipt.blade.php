@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Transfer Stepper --}}
    <div class="mx-auto mb-4" style="max-width: 680px;">
        <div class="d-flex justify-content-between align-items-center small text-secondary px-2">
            <span class="d-inline-flex align-items-center gap-1 text-success fw-semibold">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                Details
            </span>
            <span class="text-muted">──────</span>
            <span class="d-inline-flex align-items-center gap-1 text-success fw-semibold">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                Review
            </span>
            <span class="text-muted">──────</span>
            <span class="fw-bold text-success d-inline-flex align-items-center gap-1">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #16a34a; color: #fff; display: inline-grid; place-items: center; font-size: 0.7rem;">✓</span>
                Completed
            </span>
        </div>
    </div>

    <div class="surface-card p-4 p-md-5 mx-auto" style="max-width: 680px;">
        <div class="text-center mb-4">
            <div style="width: 3.5rem; height: 3.5rem; border-radius: 50%; background: #dcfce7; color: #15803d; display: grid; place-items: center; margin: 0 auto 1rem;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <span class="eyebrow eyebrow-gold mb-2">Ledger Execution Finalized</span>
            <h1 class="h3 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Transfer Completed Successfully</h1>
            <p class="text-secondary small mb-0">Funds have been deducted and journaled to the double-entry audit ledger.</p>
        </div>

        <div class="p-4 rounded-3 bg-light border mb-4">
            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                <span class="text-secondary small text-uppercase fw-semibold tracking-wider">Settled Amount</span>
                <span class="fs-4 fw-bold text-success">${{ number_format($transfer->amount, 2) }} <span class="fs-6 fw-normal text-secondary">{{ $transfer->currency }}</span></span>
            </div>

            <dl class="row mb-0 gy-3">
                <dt class="col-sm-4 text-secondary small">Transaction Reference</dt>
                <dd class="col-sm-8 font-monospace fw-bold mb-0 text-dark">{{ $transfer->reference }}</dd>

                <dt class="col-sm-4 text-secondary small">Beneficiary</dt>
                <dd class="col-sm-8 fw-semibold mb-0 text-dark">{{ $transfer->beneficiary->display_name }}</dd>

                <dt class="col-sm-4 text-secondary small">Timestamp</dt>
                <dd class="col-sm-8 mb-0 text-dark">{{ $transfer->completed_at?->format('M j, Y H:i:s') ?? now()->format('M j, Y H:i:s') }} UTC</dd>

                @if($transfer->user_reference)
                    <dt class="col-sm-4 text-secondary small">Reference Note</dt>
                    <dd class="col-sm-8 mb-0 text-secondary">{{ $transfer->user_reference }}</dd>
                @endif

                <dt class="col-sm-4 text-secondary small">Status</dt>
                <dd class="col-sm-8 mb-0">
                    <span class="badge-status badge-active">Settled &amp; Reconciled</span>
                </dd>
            </dl>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <a class="btn btn-icf-primary py-3 px-4 fw-bold flex-grow-1 text-center" href="{{ route('documents.receipt', $transfer) }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Download Official PDF Receipt
            </a>
            <a class="btn btn-icf-secondary py-3 px-4 text-center" href="{{ route('dashboard') }}">
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
