@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/details.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Confirm Payment Instructions</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">Review the transaction coordinates and verify authorization parameters.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-active px-3 py-2 shadow-sm" style="font-size: 0.75rem;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #4ade80; display: inline-block;"></span>
                Ready for Authorization
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
                <div class="d-flex align-items-center justify-content-center gap-2 fw-bold text-primary">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: var(--icf-blue); color: #fff; display: inline-grid; place-items: center; font-size: 0.75rem;">2</span>
                    <span class="d-none d-sm-inline">2. Review &amp; Verify</span>
                    <span class="d-inline d-sm-none">Review</span>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex align-items-center justify-content-center gap-2 text-muted">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-grid; place-items: center; font-size: 0.75rem;">3</span>
                    <span class="d-none d-sm-inline">3. Execution &amp; Receipt</span>
                    <span class="d-inline d-sm-none">Receipt</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Review Breakdown (Left Column) --}}
        <div class="col-lg-8">
            <div class="surface-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                        <div>
                            <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Transaction Summary</h2>
                        </div>
                        <span class="badge" style="background: rgba(37,99,235,0.08); color: var(--icf-blue); border: 1px solid rgba(37,99,235,0.18); font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">
                            Pending Confirmation
                        </span>
                    </div>

                    <div class="p-4 rounded-3 border mb-4" style="background: rgba(248, 250, 255, 0.9); border-color: rgba(37,99,235,0.12) !important;">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pb-3 border-bottom mb-3 gap-2">
                            <span class="text-secondary small text-uppercase fw-semibold tracking-wider">Settlement Amount</span>
                            <span class="fs-3 fw-bold text-primary">${{ number_format($data['amount'], 2) }} <span class="fs-6 fw-normal text-secondary">{{ $account->currency }}</span></span>
                        </div>

                        <dl class="row mb-0 gy-3">
                            <dt class="col-sm-4 text-secondary small">Source Debit Account</dt>
                            <dd class="col-sm-8 fw-semibold mb-0 text-dark">
                                {{ $account->name }}
                                <div class="text-muted font-monospace small">{{ $account->account_reference }}</div>
                            </dd>

                            <dt class="col-sm-4 text-secondary small">Beneficiary Recipient</dt>
                            <dd class="col-sm-8 fw-semibold mb-0 text-dark">{{ $beneficiary->display_name }}</dd>

                            <dt class="col-sm-4 text-secondary small">Receiving Financial Institution</dt>
                            <dd class="col-sm-8 mb-0 text-dark">{{ $beneficiary->institution_name ?: 'Designated Institution' }}</dd>

                            <dt class="col-sm-4 text-secondary small">Account / IBAN Identifier</dt>
                            <dd class="col-sm-8 font-monospace mb-0 text-dark">{{ $beneficiary->account_identifier }}</dd>

                            @if(!empty($beneficiary->routing_number))
                                <dt class="col-sm-4 text-secondary small">Routing Number</dt>
                                <dd class="col-sm-8 font-monospace mb-0 text-dark">{{ $beneficiary->routing_number }}</dd>
                            @endif

                            @if(!empty($beneficiary->bank_address))
                                <dt class="col-sm-4 text-secondary small">Bank Address</dt>
                                <dd class="col-sm-8 mb-0 text-dark">{{ $beneficiary->bank_address }}</dd>
                            @endif

                            @if(!empty($data['reference']))
                                <dt class="col-sm-4 text-secondary small">Reference Memo</dt>
                                <dd class="col-sm-8 mb-0 text-secondary">{{ $data['reference'] }}</dd>
                            @endif

                            <dt class="col-sm-4 text-secondary small">Processing Execution</dt>
                            <dd class="col-sm-8 mb-0 text-success small fw-semibold">Instant Atomic Ledger Posting</dd>
                        </dl>
                    </div>
                </div>

                <form method="POST" action="{{ route('transfers.confirm') }}" class="mt-2">
                    @csrf
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <button class="btn btn-icf-primary py-3 px-4 fw-bold fs-6 flex-grow-1" type="submit">
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

        {{-- Companion Information (Right Column) --}}
        <div class="col-lg-4">
            {{-- Account Balance Impact --}}
            <div class="surface-card p-4 mb-4">
                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <div class="feature-icon" style="width: 2.2rem; height: 2.2rem; background: rgba(37,99,235,0.08); border-color: rgba(37,99,235,0.18);">
                        <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12.01" y2="8"/><line x1="12" y1="16" x2="12" y2="12"/></svg>
                    </div>
                    <h3 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Balance Impact</h3>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2 border-bottom small text-secondary">
                    <span>Current Balance</span>
                    <strong class="text-dark">${{ number_format($account->balance, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom small text-danger">
                    <span>Transfer Debit</span>
                    <strong>-${{ number_format($data['amount'], 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-3 small">
                    <span class="fw-semibold text-dark">Estimated Ending Balance</span>
                    <strong class="text-primary fs-6">${{ number_format($account->balance - $data['amount'], 2) }}</strong>
                </div>

                <div class="mt-4 p-3 rounded-3 small d-flex align-items-start gap-2 bg-light border text-secondary">
                    <svg width="16" height="16" class="flex-shrink-0 mt-1" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <div class="lh-sm" style="font-size: 0.74rem;">
                        <strong>Settlement Policy:</strong> Domestic ACH and Fedwire transfers settle according to daily institutional cut-off windows.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
