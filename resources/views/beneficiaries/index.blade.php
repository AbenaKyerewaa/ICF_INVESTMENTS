@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/beneficiary.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Beneficiary Registry</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">Maintain and manage registered beneficiaries designated for authorized fund transfers.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a class="btn btn-icf-primary shadow-sm" href="{{ route('transfers.create') }}">
                Transfer to Beneficiary
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    {{-- Top Institutional Metrics Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="metric-card p-3 p-md-4 h-100">
                <div class="metric-label">Registered Profiles</div>
                <div class="metric-value text-primary mb-1">{{ $beneficiaries->total() ?? $beneficiaries->count() }}</div>
                <span class="text-muted small" style="font-size: 0.75rem;">Verified counterparties</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="metric-card p-3 p-md-4 h-100">
                <div class="metric-label">Active Recipients</div>
                <div class="metric-value text-success mb-1">{{ $beneficiaries->where('status', 'active')->count() }}</div>
                <span class="text-muted small" style="font-size: 0.75rem;">Eligible for disbursement</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="metric-card p-3 p-md-4 h-100">
                <div class="metric-label">Supported Rails</div>
                <div class="metric-value fs-5 mb-1 text-dark">ACH • Fedwire • SWIFT</div>
                <span class="text-muted small" style="font-size: 0.75rem;">Domestic &amp; international</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="metric-card p-3 p-md-4 h-100">
                <div class="metric-label">Compliance Clearance</div>
                <div class="metric-value fs-5 mb-1 text-success d-flex align-items-center gap-1">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    <span>100% Screened</span>
                </div>
                <span class="text-muted small" style="font-size: 0.75rem;">Automated OFAC checks</span>
            </div>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        {{-- Register Beneficiary Form (Expanded Column) --}}
        <div class="col-lg-6 align-self-start">
            <div class="surface-card p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <div class="feature-icon" style="width: 2.6rem; height: 2.6rem; background: rgba(37,99,235,0.08); border-color: rgba(37,99,235,0.18);">
                                <svg width="18" height="18" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            </div>
                            <div>
                                <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Register Beneficiary</h2>
                                <span class="text-muted small" style="font-size: 0.78rem;">New recipient authorization</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary small mb-4">Enter the beneficiary's details to establish an authorized transfer recipient record.</p>

                    <form method="POST" action="{{ route('beneficiaries.store') }}" id="registerBeneficiaryForm">
                        @csrf
                        
                        {{-- Recipient Names (2 Columns) --}}
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold" for="first_name">First Name</label>
                                <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="e.g. John" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold" for="last_name">Last Name</label>
                                <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Doe" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Account Number / IBAN & Routing Number (2 Columns) --}}
                        <div class="row g-3 mb-3">
                            <div class="col-sm-7">
                                <label class="form-label small fw-semibold" for="account_identifier">Account Number / IBAN</label>
                                <input class="form-control font-monospace @error('account_identifier') is-invalid @enderror" id="account_identifier" name="account_identifier" value="{{ old('account_identifier') }}" placeholder="e.g. Enter account number" required>
                                <div class="form-text small text-muted" style="font-size: 0.72rem;">Domestic account number or IBAN.</div>
                                @error('account_identifier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-5">
                                <label class="form-label small fw-semibold" for="routing_number">Routing Number</label>
                                <input class="form-control font-monospace @error('routing_number') is-invalid @enderror" id="routing_number" name="routing_number" value="{{ old('routing_number') }}" placeholder="e.g. Enter routing number">
                                <div class="form-text small text-muted" style="font-size: 0.72rem;">9-digit ABA routing code.</div>
                                @error('routing_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Financial Institution --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" for="institution_name">Bank Name</label>
                            <input class="form-control @error('institution_name') is-invalid @enderror" id="institution_name" name="institution_name" value="{{ old('institution_name') }}" placeholder="e.g. JPMorgan Chase Bank">
                            @error('institution_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bank Address (Separated Placeholders) --}}
                        <div class="mb-4">
                            <label class="form-label small fw-semibold d-block mb-2">Bank Address</label>
                            
                            {{-- Branch Street Address --}}
                            <div class="mb-2">
                                <input class="form-control @error('bank_street') is-invalid @enderror" id="bank_street" name="bank_street" value="{{ old('bank_street') }}" placeholder="Branch Street Address (e.g. 270 Park Avenue, Suite 400)">
                                @error('bank_street')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City & State/Province --}}
                            <div class="row g-2 mb-2">
                                <div class="col-sm-6">
                                    <input class="form-control @error('bank_city') is-invalid @enderror" id="bank_city" name="bank_city" value="{{ old('bank_city') }}" placeholder="City (e.g. New York)">
                                    @error('bank_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control @error('bank_state') is-invalid @enderror" id="bank_state" name="bank_state" value="{{ old('bank_state') }}" placeholder="State / Province (e.g. NY)">
                                    @error('bank_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Postal Code & Country --}}
                            <div class="row g-2">
                                <div class="col-sm-5">
                                    <input class="form-control @error('bank_postal_code') is-invalid @enderror" id="bank_postal_code" name="bank_postal_code" value="{{ old('bank_postal_code') }}" placeholder="Postal Code (e.g. 10017)">
                                    @error('bank_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-7">
                                    <input class="form-control @error('bank_country') is-invalid @enderror" id="bank_country" name="bank_country" value="{{ old('bank_country') }}" placeholder="Country (e.g. United States)">
                                    @error('bank_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="bank_address" id="bank_address" value="{{ old('bank_address') }}">
                            @error('bank_address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text small text-muted mt-2" style="font-size: 0.72rem;">Enter branch street address, city, state/province, postal code, and country for routing verification.</div>
                        </div>

                        {{-- Security Advisory Box --}}
                        <div class="p-3 bg-light rounded-3 border mb-4 small text-secondary d-flex align-items-start gap-2">
                            <svg width="16" height="16" class="flex-shrink-0 mt-1" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <div class="lh-sm" style="font-size: 0.75rem;">
                                Counterparty records are screened against institutional directories. Ensure all banking coordinates match official wire instructions.
                            </div>
                        </div>

                        <button class="btn btn-icf-primary w-100 py-3 fw-bold fs-6" type="submit">
                            Register Beneficiary
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        {{-- Beneficiary Directory (Right Column) --}}
        <div class="col-lg-6">
            <div class="surface-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pb-3 border-bottom">
                        <div>
                            <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Registered Beneficiaries</h2>
                            <span class="text-secondary small">{{ $beneficiaries->total() ?? $beneficiaries->count() }} registered beneficiary profiles</span>
                        </div>
                        <span class="badge-status badge-active">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #16a34a; display: inline-block;"></span>
                            Verified Directory
                        </span>
                    </div>

                    <div class="d-grid gap-3">
                        @forelse($beneficiaries as $beneficiary)
                            <div class="p-3 p-md-4 rounded-3 border bg-white d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 shadow-sm hover-shadow transition" style="border-color: rgba(228, 233, 242, 0.9) !important;">
                                <div class="d-flex align-items-start gap-3">
                                    <div style="width: 3rem; height: 3rem; border-radius: 50%; background: linear-gradient(135deg, rgba(37,99,235,0.15) 0%, rgba(99,102,241,0.2) 100%); color: var(--icf-blue); display: grid; place-items: center; font-weight: 800; font-size: 1rem; flex-shrink: 0; border: 1px solid rgba(37,99,235,0.2);">
                                        {{ strtoupper(substr($beneficiary->display_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <h3 class="h6 fw-bold mb-0 text-dark">{{ $beneficiary->display_name }}</h3>
                                            <span class="badge-status {{ $beneficiary->status === 'active' ? 'badge-active' : 'badge-disabled' }}" style="font-size: 0.65rem;">
                                                {{ ucfirst($beneficiary->status) }}
                                            </span>
                                        </div>
                                        <div class="text-secondary small mt-1">
                                            <span class="fw-semibold text-dark">{{ $beneficiary->institution_name ?: 'Standard Financial Institution' }}</span>
                                            <span class="mx-1 text-muted">•</span>
                                            <span class="font-monospace text-muted">{{ $beneficiary->account_identifier }}</span>
                                        </div>
                                        @if($beneficiary->bank_address)
                                            <div class="text-muted small mt-2 d-flex align-items-center gap-1" style="font-size: 0.74rem;">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                <span>{{ $beneficiary->bank_address }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0 align-self-end align-self-sm-center flex-wrap">
                                    @if($beneficiary->status === 'active')
                                        <a class="btn btn-sm btn-outline-primary fw-semibold" href="{{ route('transfers.create') }}" title="Transfer Funds">
                                            Transfer
                                        </a>
                                        <button 
                                            type="button" 
                                            class="btn btn-sm btn-outline-secondary fw-semibold d-inline-flex align-items-center gap-1"
                                            title="Modify Beneficiary"
                                            onclick='openModifyModal(@json($beneficiary))'
                                        >
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            Modify
                                        </button>
                                        <form method="POST" action="{{ route('beneficiaries.deactivate', $beneficiary) }}" onsubmit="return confirm('Deactivate this beneficiary?');">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Deactivate</button>
                                        </form>
                                    @else
                                        <button 
                                            type="button" 
                                            class="btn btn-sm btn-outline-secondary fw-semibold d-inline-flex align-items-center gap-1"
                                            title="Modify Beneficiary"
                                            onclick='openModifyModal(@json($beneficiary))'
                                        >
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            Modify
                                        </button>
                                        <span class="badge bg-light text-muted border px-2 py-1 small">Archived</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem; background: rgba(37,99,235,0.06); border-color: rgba(37,99,235,0.15);">
                                    <svg width="22" height="22" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <div class="h6 fw-bold text-dark mb-1">No beneficiaries registered yet</div>
                                <div class="small text-secondary mb-3">Use the registration form on the left to add your first counterparty.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($beneficiaries->hasPages())
                    <div class="pt-4 mt-3 border-top">
                        {{ $beneficiaries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

{{-- Modify Beneficiary Modal --}}
<div class="modal fade" id="modifyBeneficiaryModal" tabindex="-1" aria-labelledby="modifyBeneficiaryModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 2.2rem; height: 2.2rem; border-radius: 50%; background: rgba(37,99,235,0.1); color: var(--icf-blue); display: grid; place-items: center;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="modifyBeneficiaryModalLabel">Modify Beneficiary Profile</h5>
                        <span class="small text-muted" style="font-size: 0.75rem;">Edit approved counterparty banking coordinates</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="modifyBeneficiaryForm" method="POST" action="">
                @csrf
                @method('PATCH')

                <div class="modal-body p-4">
                    {{-- Display Name --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="mod_display_name">Beneficiary Full / Company Name</label>
                        <input class="form-control" id="mod_display_name" name="display_name" required placeholder="e.g. John Doe or Acme Corp">
                        <div class="form-text small text-muted" style="font-size: 0.72rem;">Legal entity name as registered with the receiving bank.</div>
                    </div>

                    {{-- Account Number & Financial Institution (2 Columns) --}}
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold" for="mod_account_identifier">Account Number / IBAN</label>
                            <input class="form-control font-monospace" id="mod_account_identifier" name="account_identifier" required placeholder="e.g. Domestic account number or IBAN">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold" for="mod_institution_name">Financial Institution</label>
                            <input class="form-control" id="mod_institution_name" name="institution_name" placeholder="e.g. JPMorgan Chase Bank">
                        </div>
                    </div>

                    {{-- Bank Address (Expanded fields matching Add Form) --}}
                    <div class="mb-4">
                        <label class="form-label small fw-semibold d-block mb-2">Bank Address</label>

                        {{-- Branch Street Address --}}
                        <div class="mb-2">
                            <input class="form-control" id="mod_bank_street" name="bank_street" placeholder="Branch Street Address (e.g. 270 Park Avenue, Suite 400)">
                        </div>

                        {{-- City & State/Province --}}
                        <div class="row g-2 mb-2">
                            <div class="col-sm-6">
                                <input class="form-control" id="mod_bank_city" name="bank_city" placeholder="City (e.g. New York)">
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" id="mod_bank_state" name="bank_state" placeholder="State / Province (e.g. NY)">
                            </div>
                        </div>

                        {{-- Postal Code & Country --}}
                        <div class="row g-2">
                            <div class="col-sm-5">
                                <input class="form-control" id="mod_bank_postal_code" name="bank_postal_code" placeholder="Postal Code (e.g. 10017)">
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" id="mod_bank_country" name="bank_country" placeholder="Country (e.g. United States)">
                            </div>
                        </div>

                        <input type="hidden" name="bank_address" id="mod_bank_address" value="">
                        <div class="form-text small text-muted mt-2" style="font-size: 0.72rem;">Enter branch street address, city, state/province, postal code, and country for routing verification.</div>
                    </div>

                    {{-- Notice --}}
                    <div class="p-3 bg-light rounded-3 border small text-secondary d-flex align-items-start gap-2">
                        <svg width="16" height="16" class="flex-shrink-0 mt-1" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <div class="lh-sm" style="font-size: 0.75rem;">
                            Modifications to beneficiary information will update all subsequent transfer routing parameters. An audit log entry will be created.
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary py-2 px-3 fw-semibold small" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-icf-primary py-2 px-4 fw-bold small shadow-sm d-inline-flex align-items-center gap-2">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        Save Modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let modifyModalInstance = null;

function openModifyModal(beneficiary) {
    if (!beneficiary) return;

    const form = document.getElementById('modifyBeneficiaryForm');
    form.action = `/beneficiaries/${beneficiary.id}`;

    document.getElementById('mod_display_name').value = beneficiary.display_name || '';
    document.getElementById('mod_account_identifier').value = beneficiary.account_identifier || '';
    document.getElementById('mod_institution_name').value = beneficiary.institution_name || '';

    const rawAddr = beneficiary.bank_address || '';
    document.getElementById('mod_bank_address').value = rawAddr;

    // Split comma-separated address into branch components if available
    const parts = rawAddr.split(',').map(s => s.trim()).filter(Boolean);
    if (parts.length >= 5) {
        document.getElementById('mod_bank_street').value = parts[0] || '';
        document.getElementById('mod_bank_city').value = parts[1] || '';
        document.getElementById('mod_bank_state').value = parts[2] || '';
        document.getElementById('mod_bank_postal_code').value = parts[3] || '';
        document.getElementById('mod_bank_country').value = parts.slice(4).join(', ') || '';
    } else if (parts.length === 4) {
        document.getElementById('mod_bank_street').value = parts[0] || '';
        document.getElementById('mod_bank_city').value = parts[1] || '';
        document.getElementById('mod_bank_state').value = parts[2] || '';
        document.getElementById('mod_bank_postal_code').value = '';
        document.getElementById('mod_bank_country').value = parts[3] || '';
    } else {
        document.getElementById('mod_bank_street').value = rawAddr;
        document.getElementById('mod_bank_city').value = '';
        document.getElementById('mod_bank_state').value = '';
        document.getElementById('mod_bank_postal_code').value = '';
        document.getElementById('mod_bank_country').value = '';
    }

    if (!modifyModalInstance) {
        modifyModalInstance = new bootstrap.Modal(document.getElementById('modifyBeneficiaryModal'));
    }
    modifyModalInstance.show();
}

document.addEventListener('DOMContentLoaded', function () {
    // Add Form Address Synchronizer
    const streetInput = document.getElementById('bank_street');
    const cityInput = document.getElementById('bank_city');
    const stateInput = document.getElementById('bank_state');
    const postalInput = document.getElementById('bank_postal_code');
    const countryInput = document.getElementById('bank_country');
    const hiddenAddress = document.getElementById('bank_address');

    function syncAddress() {
        if (!hiddenAddress) return;
        const parts = [
            streetInput ? streetInput.value.trim() : '',
            cityInput ? cityInput.value.trim() : '',
            stateInput ? stateInput.value.trim() : '',
            postalInput ? postalInput.value.trim() : '',
            countryInput ? countryInput.value.trim() : ''
        ].filter(Boolean);
        hiddenAddress.value = parts.join(', ');
    }

    [streetInput, cityInput, stateInput, postalInput, countryInput].forEach(function (el) {
        if (el) el.addEventListener('input', syncAddress);
    });

    // Modify Form Address Synchronizer
    const modStreet = document.getElementById('mod_bank_street');
    const modCity = document.getElementById('mod_bank_city');
    const modState = document.getElementById('mod_bank_state');
    const modPostal = document.getElementById('mod_bank_postal_code');
    const modCountry = document.getElementById('mod_bank_country');
    const modHiddenAddress = document.getElementById('mod_bank_address');

    function syncModAddress() {
        if (!modHiddenAddress) return;
        const parts = [
            modStreet ? modStreet.value.trim() : '',
            modCity ? modCity.value.trim() : '',
            modState ? modState.value.trim() : '',
            modPostal ? modPostal.value.trim() : '',
            modCountry ? modCountry.value.trim() : ''
        ].filter(Boolean);
        modHiddenAddress.value = parts.join(', ');
    }

    [modStreet, modCity, modState, modPostal, modCountry].forEach(function (el) {
        if (el) el.addEventListener('input', syncModAddress);
    });
});
</script>
@endsection
