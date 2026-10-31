@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/dashboard.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <div class="mb-2">
                <span class="eyebrow eyebrow-gold">✦ Portfolio Intelligence &amp; Analytics</span>
            </div>
            <h1 class="h2 fw-bold mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Welcome, {{ auth()->user()->name }}</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">Private wealth management overview &amp; verified ledger records.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(($unreadNotificationsCount ?? 0) > 0)
                <a class="btn btn-topbar position-relative shadow-sm" href="{{ route('notifications.index') }}" title="Alerts" style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(255, 255, 255, 0.5);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Alerts
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .65rem;">
                        {{ $unreadNotificationsCount }}
                    </span>
                </a>
            @endif
            @if($account)
                <a class="btn btn-icf-primary shadow-sm" href="{{ route('transfers.create') }}">
                    New Transfer
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>

    @if($account)
        <!-- Balance & Account Highlight Card -->
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="d-flex flex-column gap-3 h-100">
                    {{-- Primary Checkings Account Card --}}
                    <div class="balance-card d-flex flex-column justify-content-between position-relative flex-grow-1">
                        <div class="balance-glow"></div>
                        <div style="position: relative; z-index: 1;">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <span class="badge-status badge-active mb-2" style="background: rgba(34, 197, 94, 0.18); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.3);">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #4ade80; display: inline-block;"></span>
                                        {{ ucfirst($account->status) }} Account
                                    </span>
                                    <h2 class="h5 fw-bold text-white mb-0">{{ $account->name }}</h2>
                                    <p class="text-white-50 font-monospace small mb-0 mt-1">{{ $account->account_reference }}</p>
                                </div>
                            </div>
                            <p class="text-white-50 small mb-1 text-uppercase tracking-wider" style="letter-spacing: 0.08em; font-size: 0.72rem;">Available Balance</p>
                            <div class="display-6 fw-bold mb-3 text-white">
                                ${{ number_format($account->balance, 2) }}
                                <span class="fs-6 text-white-50 fw-normal ms-1">{{ $account->currency }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top border-white-50 small text-white-50" style="position: relative; z-index: 1; border-color: rgba(255,255,255,0.15) !important;">
                            <a class="text-white text-decoration-none d-inline-flex align-items-center gap-1 fw-semibold" href="{{ route('accounts.show', $account) }}">
                                <span>View Transaction history</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                            <span class="d-inline-flex align-items-center gap-1 text-white-50">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                                Continuous Reconciled
                            </span>
                        </div>
                    </div>

                    {{-- Dedicated Savings Account Card --}}
                    @if($savingsAccount)
                        <div class="balance-card d-flex flex-column justify-content-between position-relative p-4" style="box-shadow: 0 10px 25px -5px rgba(2, 6, 23, 0.4);">
                            <div class="balance-glow"></div>
                            <div style="position: relative; z-index: 1;">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                            <span class="badge-status badge-active" style="background: rgba(56, 189, 248, 0.18); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.35); font-size: 0.68rem;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #38bdf8; display: inline-block;"></span>
                                                Savings Vault
                                            </span>
                                        </div>
                                        <h2 class="h5 fw-bold text-white mb-0">{{ $savingsAccount->name }}</h2>
                                        <p class="text-white-50 font-monospace small mb-0 mt-1">{{ $savingsAccount->account_reference }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-white-50 small mb-1 text-uppercase tracking-wider" style="letter-spacing: 0.08em; font-size: 0.7rem;">Vault Balance</p>
                                        <div class="h3 fw-bold text-white mb-0">
                                            ${{ number_format($savingsAccount->balance, 2) }}
                                            <span class="fs-6 text-white-50 fw-normal ms-1">{{ $savingsAccount->currency }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top small text-white-50" style="position: relative; z-index: 1; border-color: rgba(255, 255, 255, 0.15) !important;">
                                <span class="d-inline-flex align-items-center gap-1" style="color: #cbd5e1; font-size: 0.78rem;">
                                    <svg width="13" height="13" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Capital Reserve Vault
                                </span>
                                <span class="d-inline-flex align-items-center gap-1 text-white-50" style="font-size: 0.78rem;">
                                    <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                                    Protected Principal
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="surface-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Quick actions</h2>
                            <span class="text-muted small" style="font-size: 0.75rem;">Verified operations</span>
                        </div>
                        <div class="d-grid gap-3">
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('transfers.create') }}">
                                <span class="d-inline-flex align-items-start gap-3">
                                    <span class="sidebar-icon mt-1" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </span>
                                    <span>
                                        <span class="fw-bold d-block text-dark">Transfer funds</span>
                                        <span class="text-secondary small d-block" style="font-size: 0.76rem; font-weight: normal;">Send funds to an approved counterparty with instant clearing.</span>
                                    </span>
                                </span>
                                <span class="text-muted fs-5">→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('beneficiaries.index') }}">
                                <span class="d-inline-flex align-items-start gap-3">
                                    <span class="sidebar-icon mt-1" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    </span>
                                    <span>
                                        <span class="fw-bold d-block text-dark">Manage saved beneficiaries</span>
                                        <span class="text-secondary small d-block" style="font-size: 0.76rem; font-weight: normal;">Add and review verified recipients for future transfers.</span>
                                    </span>
                                </span>
                                <span class="text-muted fs-5">→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('accounts.show', $account) }}">
                                <span class="d-inline-flex align-items-start gap-3">
                                    <span class="sidebar-icon mt-1" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </span>
                                    <span>
                                        <span class="fw-bold d-block text-dark">Download PDF statement</span>
                                        <span class="text-secondary small d-block" style="font-size: 0.76rem; font-weight: normal;">Generate official account records and transaction summaries.</span>
                                    </span>
                                </span>
                                <span class="text-muted fs-5">→</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top small text-secondary d-flex align-items-center justify-content-between">
                        <span>Reconciled against {{ $analytics['transactionCount'] ?? 0 }} entries</span>
                        <span class="text-success fw-semibold">100% Match</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="surface-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Recent transaction entries</h2>
                    <p class="text-secondary small mb-0">Latest verified credits and debits posted to this account.</p>
                </div>
                <a class="btn btn-sm btn-icf-secondary" href="{{ route('accounts.show', $account) }}">View all transactions →</a>
            </div>
            
            <div class="table-responsive">
                <table class="icf-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEntries as $entry)
                            <tr>
                                <td class="text-secondary small">{{ $entry->occurred_at->format('M j, Y') }}</td>
                                <td class="font-monospace small fw-semibold text-dark">{{ $entry->entry_reference }}</td>
                                <td class="fw-semibold">{{ $entry->description }}</td>
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
                                <td colspan="5" class="text-center text-secondary py-4">No activity recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="surface-card p-5 text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                <svg width="24" height="24" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h2 class="h5 fw-bold">No active account assigned</h2>
            <p class="text-secondary mb-0">An administrator can assign an active investment account before activity becomes available.</p>
        </div>
    @endif
</div>
</div>
@endsection
