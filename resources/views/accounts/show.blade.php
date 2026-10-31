@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/active.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a class="text-white-50 text-decoration-none small" href="{{ route('dashboard') }}">← Dashboard</a>
                <span class="text-white-50 small">/</span>
                <span class="text-white small fw-semibold">Account Activity</span>
            </div>
            <h1 class="h2 fw-bold mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">{{ $account->name }}</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">
                <span class="font-monospace fw-semibold">{{ $account->account_reference }}</span>
                <span class="mx-2">•</span>
                <span class="badge-status badge-active px-2 py-1" style="font-size: 0.7rem;">{{ ucfirst($account->status) }}</span>
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-icf-secondary shadow-sm" href="{{ route('documents.statement', ['account' => $account, 'from' => '2024-01-01', 'to' => '2024-12-31']) }}" style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(255, 255, 255, 0.5);">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Download PDF Statement
            </a>
            <a class="btn btn-icf-primary shadow-sm" href="{{ route('transfers.create') }}">
                Transfer Funds
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    {{-- Account Balance Summary Hero --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="metric-card h-100">
                <span class="metric-label">Current Balance</span>
                <div class="metric-value my-2" style="font-size: 2rem; color: var(--icf-navy);">
                    ${{ number_format( $account->balance, 2) }}
                    <span class="fs-6 text-muted fw-normal">{{ $account->currency }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            {{-- Filter Toolbar --}}
            <div class="surface-card p-4 h-100 d-flex flex-column justify-content-center">
                <h2 class="h6 fw-bold mb-3" style="color: var(--icf-navy);">Search Account Records</h2>
                <form method="GET" action="{{ route('accounts.show', $account) }}" class="row g-2 align-items-end">
                    <div class="col-sm-4">
                        <label class="form-label small text-secondary mb-1">From Date</label>
                        <input class="form-control form-control-sm" name="from" type="date" value="{{ request('from') }}">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small text-secondary mb-1">To Date</label>
                        <input class="form-control form-control-sm" name="to" type="date" value="{{ request('to') }}">
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label small text-secondary mb-1">Type</label>
                        <select class="form-select form-select-sm" name="type">
                            <option value="">All Types</option>
                            <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Credits</option>
                            <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Debits</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-sm btn-icf-primary w-100" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="surface-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Transaction Activity</h2>
            </div>
            @if(request()->hasAny(['from', 'to', 'type']))
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('accounts.show', $account) }}">Clear filters</a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="icf-table">
                <thead>
                    <tr>
                        <th>Date &amp; Time</th>
                        <th>Reference</th>
                        <th>Description</th>
                        <th>Entry Type</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                        <tr>
                            <td class="text-secondary small">
                                {{ $entry->occurred_at->format('M j, Y') }}
                                <div class="text-muted" style="font-size: 0.72rem;">{{ $entry->occurred_at->format('H:i:s') }}</div>
                            </td>
                            <td class="font-monospace small fw-semibold text-dark">{{ $entry->entry_reference }}</td>
                            <td>
                                <div class="fw-semibold">{{ $entry->description }}</div>
                            </td>
                            <td>
                                <span class="badge-status {{ $entry->entry_type === 'credit' ? 'badge-credit' : 'badge-debit' }}">
                                    {{ ucfirst($entry->entry_type) }}
                                </span>
                            </td>
                            <td class="text-end fw-bold {{ $entry->entry_type === 'credit' ? 'text-success' : 'text-danger' }}">
                                {{ $entry->entry_type === 'credit' ? '+' : '-' }}${{ number_format($entry->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-5">
                                <div class="feature-icon mx-auto mb-2" style="width: 3rem; height: 3rem;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                                </div>
                                <div class="fw-semibold">No matching activity</div>
                                <div class="small">Try resetting your filters to see all account records.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pagination-wrapper">
            {{ $entries->links() }}
        </div>
    </div>
</div>
</div>
@endsection
