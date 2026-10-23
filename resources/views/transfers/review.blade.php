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
            <span class="fw-bold text-primary d-inline-flex align-items-center gap-1">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: var(--icf-blue); color: #fff; display: inline-grid; place-items: center; font-size: 0.7rem;">2</span>
                Review
            </span>
            <span class="text-muted">──────</span>
            <span class="d-inline-flex align-items-center gap-1 text-muted">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-grid; place-items: center; font-size: 0.7rem;">3</span>
                Receipt
            </span>
        </div>
    </div>

    <div class="surface-card p-4 p-md-5 mx-auto" style="max-width: 680px;">
        <div class="mb-4">
            <span class="eyebrow eyebrow-gold mb-2">Authorization Gate</span>
            <h1 class="h3 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Confirm Payment Instructions</h1>
            <p class="text-secondary small mb-0">Please review transfer instructions before cryptographic ledger execution.</p>
        </div>

        <div class="p-4 rounded-3 bg-light border mb-4">
            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                <span class="text-secondary small text-uppercase fw-semibold tracking-wider">Transfer Amount</span>
                <span class="fs-4 fw-bold text-primary">${{ number_format($data['amount'], 2) }} <span class="fs-6 fw-normal text-secondary">{{ $account->currency }}</span></span>
            </div>

            <dl class="row mb-0 gy-3">
                <dt class="col-sm-4 text-secondary small">Source Account</dt>
                <dd class="col-sm-8 fw-semibold mb-0 text-dark">
                    {{ $account->name }}
                    <div class="text-muted font-monospace small">{{ $account->account_reference }}</div>
                </dd>

                <dt class="col-sm-4 text-secondary small">Beneficiary Name</dt>
                <dd class="col-sm-8 fw-semibold mb-0 text-dark">{{ $beneficiary->display_name }}</dd>

                <dt class="col-sm-4 text-secondary small">Beneficiary Bank</dt>
                <dd class="col-sm-8 mb-0 text-dark">{{ $beneficiary->institution_name ?: 'Standard Institution' }}</dd>

                <dt class="col-sm-4 text-secondary small">Account / IBAN</dt>
                <dd class="col-sm-8 font-monospace mb-0 text-dark">{{ $beneficiary->account_identifier }}</dd>

                @if(!empty($data['reference']))
                    <dt class="col-sm-4 text-secondary small">Reference Note</dt>
                    <dd class="col-sm-8 mb-0 text-secondary">{{ $data['reference'] }}</dd>
                @endif

                <dt class="col-sm-4 text-secondary small">Processing Execution</dt>
                <dd class="col-sm-8 mb-0 text-success small fw-semibold">Instant Atomic Ledger Posting</dd>
            </dl>
        </div>

        <form method="POST" action="{{ route('transfers.confirm') }}">
            @csrf
            <div class="d-flex flex-column flex-sm-row gap-2">
                <button class="btn btn-icf-primary py-3 px-4 fw-bold flex-grow-1" type="submit">
                    Authorize &amp; Execute Transfer
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
                <a class="btn btn-icf-secondary py-3 px-4 text-center" href="{{ route('transfers.create') }}">
                    Modify Details
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
