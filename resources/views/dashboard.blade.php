@extends('layouts.app')

@section('content')
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Portfolio Intelligence &amp; Analytics</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-secondary mb-0">Private wealth management overview &amp; verified ledger records.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(($unreadNotificationsCount ?? 0) > 0)
                <a class="btn btn-topbar position-relative" href="{{ route('notifications.index') }}" title="Alerts">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Alerts
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .65rem;">
                        {{ $unreadNotificationsCount }}
                    </span>
                </a>
            @endif
            @if($account)
                <a class="btn btn-icf-primary" href="{{ route('transfers.create') }}">
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
                <div class="balance-card h-100 d-flex flex-column justify-content-between position-relative">
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
                            <span class="eyebrow eyebrow-gold" style="font-size: 0.65rem; background: rgba(201,168,76,0.18); border-color: rgba(201,168,76,0.35); color: #fde047;">
                                Verified Portfolio
                            </span>
                        </div>
                        <p class="text-white-50 small mb-1 text-uppercase tracking-wider" style="letter-spacing: 0.08em; font-size: 0.72rem;">Available Balance</p>
                        <div class="display-6 fw-bold mb-3 text-white">
                            ${{ number_format($account->balance, 2) }}
                            <span class="fs-6 text-white-50 fw-normal ms-1">{{ $account->currency }}</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top border-white-50 small text-white-50" style="position: relative; z-index: 1; border-color: rgba(255,255,255,0.15) !important;">
                        <a class="text-white text-decoration-none d-inline-flex align-items-center gap-1 fw-semibold" href="{{ route('accounts.show', $account) }}">
                            <span>View full ledger history</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <span class="d-inline-flex align-items-center gap-1 text-white-50">
                            <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Continuous Reconciled
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="surface-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Quick actions</h2>
                            <span class="text-muted small" style="font-size: 0.75rem;">Verified operations</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('transfers.create') }}">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="sidebar-icon" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </span>
                                    <span class="fw-semibold">Transfer funds</span>
                                </span>
                                <span class="text-muted">→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('beneficiaries.index') }}">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="sidebar-icon" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    </span>
                                    <span class="fw-semibold">Manage saved beneficiaries</span>
                                </span>
                                <span class="text-muted">→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center p-3" href="{{ route('accounts.show', $account) }}">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="sidebar-icon" style="background: rgba(37,99,235,.1); color: var(--icf-blue);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </span>
                                    <span class="fw-semibold">Download PDF statement</span>
                                </span>
                                <span class="text-muted">→</span>
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

        <!-- Analytics Controls & Period Summary -->
        <div class="surface-card p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Activity trends &amp; cashflow</h2>
                    <p class="text-secondary small mb-0">Aggregated server-side metrics for period {{ $analytics['startDate'] ?? '' }} to {{ $analytics['endDate'] ?? '' }}</p>
                </div>
                <!-- Date-Range Selector Controls -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Date range selector">
                        <a href="{{ route('dashboard', ['range' => '30d']) }}" class="btn {{ ($range ?? '12m') === '30d' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">30D</a>
                        <a href="{{ route('dashboard', ['range' => '90d']) }}" class="btn {{ ($range ?? '12m') === '90d' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">90D</a>
                        <a href="{{ route('dashboard', ['range' => '6m']) }}" class="btn {{ ($range ?? '12m') === '6m' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">6M</a>
                        <a href="{{ route('dashboard', ['range' => '12m']) }}" class="btn {{ ($range ?? '12m') === '12m' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">12M</a>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#customRangeCollapse" aria-expanded="false" aria-controls="customRangeCollapse">
                        Custom dates ▾
                    </button>
                </div>
            </div>

            <!-- Custom date range filter collapse -->
            <div class="collapse {{ ($from || $to) ? 'show' : '' }} mb-4" id="customRangeCollapse">
                <form method="GET" action="{{ route('dashboard') }}" class="p-3 bg-light rounded-3 row g-2 align-items-end border">
                    <div class="col-sm-5">
                        <label class="form-label small text-secondary mb-1">From Date</label>
                        <input type="date" name="from" class="form-control form-control-sm" value="{{ $from ?? '' }}" required>
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label small text-secondary mb-1">To Date</label>
                        <input type="date" name="to" class="form-control form-control-sm" value="{{ $to ?? '' }}" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-sm btn-icf-primary w-100">Apply Filter</button>
                    </div>
                </form>
            </div>

            @if($analytics && !$analytics['isEmpty'])
                <!-- Period Aggregate Metric Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="metric-card">
                            <span class="metric-label">Period Inflow (Credits)</span>
                            <div class="metric-value text-success mt-1">+${{ number_format((float) $analytics['totalCredits'], 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="metric-card">
                            <span class="metric-label">Period Outflow (Debits)</span>
                            <div class="metric-value text-danger mt-1">-${{ number_format((float) $analytics['totalDebits'], 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="metric-card">
                            <span class="metric-label">Net Cashflow</span>
                            <div class="metric-value {{ (float) $analytics['netChange'] >= 0 ? 'text-primary' : 'text-danger' }} mt-1">
                                {{ (float) $analytics['netChange'] >= 0 ? '+' : '' }}${{ number_format((float) $analytics['netChange'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="metric-card">
                            <span class="metric-label">Total Transactions</span>
                            <div class="metric-value text-dark mt-1">{{ $analytics['transactionCount'] }} records</div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Chart.js Visualizations -->
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="p-3 border rounded-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h6 fw-bold mb-0">Credit vs Debit Timeline</h3>
                                <span class="badge bg-light text-secondary border">Timeline</span>
                            </div>
                            <div style="position: relative; height: 260px; width: 100%;">
                                <canvas id="accountTrendsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="p-3 border rounded-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h6 fw-bold mb-0">Monthly Cashflow Breakdown</h3>
                                <span class="badge bg-light text-secondary border">Aggregated</span>
                            </div>
                            <div style="position: relative; height: 260px; width: 100%;">
                                <canvas id="creditsDebitsBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    window.accountChartData = @json($analytics);
                </script>
            @else
                <!-- Empty State for Charts -->
                <div class="text-center py-5 border rounded-3 bg-light">
                    <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                        <svg width="24" height="24" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-3 3"/></svg>
                    </div>
                    <h3 class="h6 fw-bold">No activity in this period</h3>
                    <p class="text-secondary small mb-3">Try adjusting your date range filter or create a transfer to populate chart data.</p>
                    <a href="{{ route('dashboard', ['range' => '12m']) }}" class="btn btn-sm btn-icf-secondary">Reset to 12 Months</a>
                </div>
            @endif

            <div class="p-3 bg-light rounded-3 border mt-4 mb-0 small text-secondary d-flex align-items-center gap-2">
                <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span><strong>Ledger verified:</strong> All transaction metrics and cashflow balances are reconciled in real-time with double-entry accounting.</span>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="surface-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Recent ledger entries</h2>
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
@endsection
