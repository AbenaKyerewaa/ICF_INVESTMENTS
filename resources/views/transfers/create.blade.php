@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Transfer Stepper --}}
    <div class="mx-auto mb-4" style="max-width: 680px;">
        <div class="d-flex justify-content-between align-items-center small text-secondary px-2">
            <span class="fw-bold text-primary d-inline-flex align-items-center gap-1">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: var(--icf-blue); color: #fff; display: inline-grid; place-items: center; font-size: 0.7rem;">1</span>
                Details
            </span>
            <span class="text-muted">──────</span>
            <span class="d-inline-flex align-items-center gap-1 text-muted">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-grid; place-items: center; font-size: 0.7rem;">2</span>
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
            <span class="eyebrow eyebrow-gold mb-2">Fund Disbursement</span>
            <h1 class="h3 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Transfer Funds</h1>
            <p class="text-secondary small mb-0">Select your source investment account and verified beneficiary.</p>
        </div>

        <form method="POST" action="{{ route('transfers.preview') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold" for="account_id">Source Account</label>
                <select class="form-select @error('account_id') is-invalid @enderror" id="account_id" name="account_id" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->name }} ({{ $account->account_reference }}) — ${{ number_format($account->balance, 2) }} {{ $account->currency }} Available
                        </option>
                    @endforeach
                </select>
                @error('account_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small fw-semibold mb-0" for="beneficiary_id">Target Beneficiary</label>
                    <a class="text-primary small text-decoration-none" href="{{ route('beneficiaries.index') }}">+ Add new beneficiary</a>
                </div>
                <select class="form-select @error('beneficiary_id') is-invalid @enderror" id="beneficiary_id" name="beneficiary_id" required>
                    @foreach($beneficiaries as $beneficiary)
                        <option value="{{ $beneficiary->id }}" {{ old('beneficiary_id') == $beneficiary->id ? 'selected' : '' }}>
                            {{ $beneficiary->display_name }} ({{ $beneficiary->institution_name ?: 'Institution' }} • {{ $beneficiary->account_identifier }})
                        </option>
                    @endforeach
                </select>
                @error('beneficiary_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold" for="amount">Transfer Amount (USD)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary fw-bold">$</span>
                    <input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" placeholder="0.00" required>
                    <span class="input-group-text bg-light text-muted small">USD</span>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text small text-muted">Transfers are processed with atomic double-entry verification.</div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold" for="reference">Reference Note (Optional)</label>
                <input class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="e.g. Portfolio Allocation, Advisory Capital">
                @error('reference')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="p-3 bg-light rounded-3 border mb-4 small text-secondary d-flex align-items-center gap-2">
                <svg width="16" height="16" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span>You will review fee details, counterparty information, and ledger impact on the next screen.</span>
            </div>

            <button class="btn btn-icf-primary w-100 py-3 fw-bold" type="submit">
                Continue to Review
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>
    </div>
</div>
@endsection
