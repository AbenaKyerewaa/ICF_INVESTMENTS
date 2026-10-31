@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/details.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Initiate Funds Transfer</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">Select the debit funding account, clearance profile, and an approved beneficiary to proceed.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a class="btn btn-topbar shadow-sm" href="{{ route('beneficiaries.index') }}" style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(255, 255, 255, 0.5);">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Beneficiary Registry
            </a>
        </div>
    </div>

    {{-- Transfer Stepper Bar --}}
    <div class="surface-card p-3 mb-4">
        <div class="row align-items-center text-center g-2">
            <div class="col-4">
                <div class="d-flex align-items-center justify-content-center gap-2 fw-bold text-primary">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: var(--icf-blue); color: #fff; display: inline-grid; place-items: center; font-size: 0.75rem;">1</span>
                    <span class="d-none d-sm-inline">1. Transfer Details</span>
                    <span class="d-inline d-sm-none">Details</span>
                </div>
            </div>
            <div class="col-4 border-start border-end">
                <div class="d-flex align-items-center justify-content-center gap-2 text-muted">
                    <span style="width: 26px; height: 26px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-grid; place-items: center; font-size: 0.75rem;">2</span>
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
        {{-- Main Transfer Form (Left Column) --}}
        <div class="col-lg-8">
            <div class="surface-card p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Funds Transfer Instructions</h2>
                        <p class="text-secondary small mb-0">Specify the funding source, execution rail, recipient, and amount.</p>
                    </div>
                    <span class="badge-status badge-active">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #16a34a; display: inline-block;"></span>
                        Verified Session
                    </span>
                </div>

                <form method="POST" action="{{ route('transfers.preview') }}">
                    @csrf
                    
                    {{-- Debit Account --}}
                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="account_id">Debit Account</label>
                        <select class="form-select @error('account_id') is-invalid @enderror" id="account_id" name="account_id" required>
                            @foreach($accounts as $account)
                                @php
                                    $isSavings = stripos($account->name, 'savings') !== false || $account->account_reference === 'ICF-SAVINGS-564';
                                @endphp
                                <option value="{{ $account->id }}" {{ $isSavings ? 'disabled' : '' }} data-balance="{{ $account->balance }}" data-currency="{{ $account->currency }}" data-ref="{{ $account->account_reference }}" data-name="{{ $account->name }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }} ({{ $account->account_reference }}) — ${{ number_format($account->balance, 2) }} {{ $account->currency }} {{ $isSavings ? '— [Deposit Only / Transfers Restricted]' : 'Available' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text small text-muted">Funds will be debited immediately upon confirmation. Outgoing transfers are authorized only from Checkings.</div>
                        @error('account_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Transfer Execution Profile --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: 700;">Transfer Processing Method</label>
                            <span class="text-muted small">Select clearing channel</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="transfer_profile" id="profile_domestic" value="domestic" checked autocomplete="off">
                                <label class="profile-card-option p-3 rounded-3 d-flex flex-column h-100" for="profile_domestic">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="profile-icon-circle bg-blue-light text-primary">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 10v11M19 10v11M9 10v11M15 10v11M12 3l9 7H3l9-7z"/></svg>
                                            </div>
                                            <span class="fw-bold text-dark small">Domestic Transfers</span>
                                        </div>
                                        <span class="badge-status badge-active" style="font-size: 0.62rem;">ACH / Wire</span>
                                    </div>
                                    <p class="text-muted mb-3 small" style="font-size: 0.78rem; line-height: 1.4;">Fedwire &amp; Automated Clearing House settlement within domestic jurisdiction.</p>
                                    <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top border-light text-secondary" style="font-size: 0.7rem;">
                                        <span>Settlement: <strong>Same-Day / 24h</strong></span>
                                        <span class="text-success fw-semibold">Standard Clearance</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="transfer_profile" id="profile_international" value="international" autocomplete="off">
                                <label class="profile-card-option p-3 rounded-3 d-flex flex-column h-100" for="profile_international">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="profile-icon-circle bg-emerald-light text-success">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                            </div>
                                            <span class="fw-bold text-dark small">International Transfers</span>
                                        </div>
                                        <span class="badge-status badge-credit" style="font-size: 0.62rem;">SWIFT / IBAN</span>
                                    </div>
                                    <p class="text-muted mb-3 small" style="font-size: 0.78rem; line-height: 1.4;">Cross-border wire via Society for Worldwide Interbank Financial Telecommunication.</p>
                                    <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top border-light text-secondary" style="font-size: 0.7rem;">
                                        <span>Settlement: <strong>1–2 Business Days</strong></span>
                                        <span class="text-primary fw-semibold">Global Gateway</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Beneficiary Account --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-semibold mb-0" for="beneficiary_id">Beneficiary Account</label>
                            <a class="text-primary small text-decoration-none fw-semibold" href="{{ route('beneficiaries.index') }}">+ Register Beneficiary</a>
                        </div>
                        <select class="form-select @error('beneficiary_id') is-invalid @enderror" id="beneficiary_id" name="beneficiary_id" required>
                            @foreach($beneficiaries as $beneficiary)
                                <option value="{{ $beneficiary->id }}" {{ old('beneficiary_id') == $beneficiary->id ? 'selected' : '' }}>
                                    {{ $beneficiary->display_name }} ({{ $beneficiary->institution_name ?: 'Institution' }} • {{ $beneficiary->account_identifier }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text small text-muted">Transfers can only be dispatched to pre-registered, verified counterparty accounts.</div>
                        @error('beneficiary_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Transfer Amount --}}
                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="amount">Transfer Amount (USD)</label>
                        <div class="input-group input-group-lg mb-2">
                            <span class="input-group-text bg-light text-secondary fw-bold">$</span>
                            <input class="form-control fw-bold @error('amount') is-invalid @enderror" id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" placeholder="0.00" required style="letter-spacing: -0.01em;">
                            <span class="input-group-text bg-light text-muted small fw-semibold">USD</span>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quick amount pills --}}
                        <div class="d-flex flex-wrap gap-2 pt-1">
                            <span class="text-muted small align-self-center me-1" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 600;">Quick Presets:</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 quick-pill" data-val="1000" style="font-size: 0.75rem;">+$1,000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 quick-pill" data-val="5000" style="font-size: 0.75rem;">+$5,000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 quick-pill" data-val="10000" style="font-size: 0.75rem;">+$10,000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 quick-pill" data-val="25000" style="font-size: 0.75rem;">+$25,000</button>
                        </div>
                    </div>

                    {{-- Transfer Reference --}}
                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="reference">Transfer Reference (Optional)</label>
                        <input class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="e.g. Bill Pay, Investment transfers, Wire transfer">
                        <div class="form-text small text-muted">Will appear on counterparty ledger memo and transaction confirmation receipt.</div>
                        @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Compliance Note --}}
                    <div class="p-3 bg-light rounded-3 border mb-4 small text-secondary d-flex align-items-center gap-3">
                        <div class="feature-icon flex-shrink-0" style="width: 2.2rem; height: 2.2rem; background: rgba(37,99,235,0.08); border-color: rgba(37,99,235,0.16);">
                            <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="lh-sm">
                            Review applicable fees, beneficiary details, and account balance impact before authorizing the transaction. All transfers are protected by 256-bit institutional encryption.
                        </div>
                    </div>

                    {{-- Action --}}
                    <button class="btn btn-icf-primary w-100 py-3 fw-bold fs-6" type="submit">
                        Review Transfer Details
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar Companion Information (Right Column) --}}
        <div class="col-lg-4">
            {{-- Account Liquidity Card --}}
            @php
                $activeAccount = $accounts->first();
            @endphp
            <div class="surface-card p-4 mb-4 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge-status badge-active" style="font-size: 0.68rem;">Active</span>
                </div>
                <div class="fw-bold fs-6 mb-1" id="sidebar_account_name" style="color: var(--icf-navy);">
                    {{ $activeAccount?->name ?? 'Operating Account' }}
                </div>
                <div class="font-monospace text-muted small mb-3" id="sidebar_account_ref">
                    {{ $activeAccount?->account_reference ?? 'ACCT-PRIMARY' }}
                </div>
                <div class="p-3 rounded-3 border mb-3" style="background: rgba(37,99,235,0.02); border-color: rgba(37,99,235,0.12) !important;">
                    <div class="text-muted small text-uppercase fw-semibold mb-1" style="font-size: 0.7rem; letter-spacing: 0.05em;">Available Balance</div>
                    <div class="h3 fw-bold text-primary mb-0" id="sidebar_account_balance">
                        ${{ number_format($activeAccount?->balance ?? 0, 2) }}
                        <span class="fs-6 text-muted fw-normal">{{ $activeAccount?->currency ?? 'USD' }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 text-muted small" style="font-size: 0.78rem;">
                    <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    <span>Instant debit clearance eligible</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accountSelect = document.getElementById('account_id');
    const nameEl = document.getElementById('sidebar_account_name');
    const refEl = document.getElementById('sidebar_account_ref');
    const balanceEl = document.getElementById('sidebar_account_balance');
    const amountInput = document.getElementById('amount');

    if (accountSelect) {
        accountSelect.addEventListener('change', function () {
            const selected = accountSelect.options[accountSelect.selectedIndex];
            if (selected) {
                if (nameEl && selected.dataset.name) nameEl.textContent = selected.dataset.name;
                if (refEl && selected.dataset.ref) refEl.textContent = selected.dataset.ref;
                if (balanceEl && selected.dataset.balance) {
                    const val = parseFloat(selected.dataset.balance).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    balanceEl.innerHTML = '$' + val + ' <span class="fs-6 text-muted fw-normal">' + (selected.dataset.currency || 'USD') + '</span>';
                }
            }
        });
    }

    document.querySelectorAll('.quick-pill').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const addVal = parseFloat(this.getAttribute('data-val')) || 0;
            const currentVal = parseFloat(amountInput.value) || 0;
            amountInput.value = (currentVal + addVal).toFixed(2);
            amountInput.dispatchEvent(new Event('input'));
        });
    });
});
</script>
@endsection
