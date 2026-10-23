@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Counterparty Directory</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Beneficiaries</h1>
            <p class="text-secondary mb-0">Authorized counterparty accounts approved for outgoing fund transfers.</p>
        </div>
        <div>
            <a class="btn btn-icf-primary" href="{{ route('transfers.create') }}">
                Transfer to Beneficiary
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Add Beneficiary Form --}}
        <div class="col-lg-4">
            <div class="surface-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.25rem; height: 2.25rem;">
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    </div>
                    <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Add Beneficiary</h2>
                </div>
                <p class="text-secondary small mb-4">Register an approved individual or entity counterparty account.</p>

                <form method="POST" action="{{ route('beneficiaries.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="display_name">Beneficiary Name</label>
                        <input class="form-control @error('display_name') is-invalid @enderror" id="display_name" name="display_name" value="{{ old('display_name') }}" placeholder="e.g. Apex Holdings LLC" required>
                        @error('display_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="account_identifier">Account / IBAN Identifier</label>
                        <input class="form-control font-monospace @error('account_identifier') is-invalid @enderror" id="account_identifier" name="account_identifier" value="{{ old('account_identifier') }}" placeholder="e.g. ACCT-7749-US" required>
                        @error('account_identifier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="institution_name">Financial Institution</label>
                        <input class="form-control @error('institution_name') is-invalid @enderror" id="institution_name" name="institution_name" value="{{ old('institution_name') }}" placeholder="e.g. JPMorgan Chase Bank">
                        @error('institution_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-icf-primary w-100 py-2 fw-bold" type="submit">
                        Save Counterparty
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Beneficiary Directory --}}
        <div class="col-lg-8">
            <div class="surface-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Registered Counterparties</h2>
                        <span class="text-secondary small">{{ $beneficiaries->count() }} active or archived profiles</span>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    @forelse($beneficiaries as $beneficiary)
                        <div class="p-3 rounded-3 border bg-light d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 2.75rem; height: 2.75rem; border-radius: 50%; background: #e0e7ff; color: #3730a3; display: grid; place-items: center; font-weight: 700; font-size: 0.95rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($beneficiary->display_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <h3 class="h6 fw-bold mb-0 text-dark">{{ $beneficiary->display_name }}</h3>
                                        <span class="badge-status {{ $beneficiary->status === 'active' ? 'badge-active' : 'badge-disabled' }}" style="font-size: 0.65rem;">
                                            {{ ucfirst($beneficiary->status) }}
                                        </span>
                                    </div>
                                    <div class="text-secondary small mt-1">
                                        <span class="fw-semibold text-dark">{{ $beneficiary->institution_name ?: 'Standard Institution' }}</span>
                                        <span class="mx-1">•</span>
                                        <span class="font-monospace text-muted">{{ $beneficiary->account_identifier }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($beneficiary->status === 'active')
                                    <form method="POST" action="{{ route('beneficiaries.deactivate', $beneficiary) }}" onsubmit="return confirm('Deactivate this beneficiary?');">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Deactivate</button>
                                    </form>
                                @else
                                    <span class="text-muted small">Archived</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="feature-icon mx-auto mb-2" style="width: 3rem; height: 3rem;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <div class="fw-semibold">No beneficiaries registered</div>
                            <div class="small text-secondary">Use the form on the left to add your first counterparty.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
