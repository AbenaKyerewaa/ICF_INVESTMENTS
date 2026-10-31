@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/analysis.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.22) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">Cashflow Analysis</h1>
            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88) !important; text-shadow: 0 1px 4px rgba(0,0,0,0.35);">
                Track your account activity, cashflow trends and financial performance
                @if($account)
                    for <span class="fw-semibold text-white">{{ $account->name }}</span> <span class="font-monospace text-white-50">({{ $account->account_reference }})</span>
                @endif
            </p>
        </div>
        @if($account)
            <div class="d-flex align-items-center gap-2">
                <a class="btn btn-icf-secondary shadow-sm" href="{{ route('accounts.show', $account) }}" style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(255, 255, 255, 0.5);">
                    View Activity
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>

    @if($account)
        <!-- Date-Range Filter Toolbar (Standalone) -->
        <div class="surface-card p-3 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-2 text-secondary small">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span>Reporting Period: <strong class="text-dark">{{ $analytics['startDate'] ?? '' }}</strong> to <strong class="text-dark">{{ $analytics['endDate'] ?? '' }}</strong></span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Date range selector">
                        <a href="{{ route('analysis', ['range' => '30d']) }}" class="btn {{ ($range ?? '12m') === '30d' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">30D</a>
                        <a href="{{ route('analysis', ['range' => '90d']) }}" class="btn {{ ($range ?? '12m') === '90d' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">90D</a>
                        <a href="{{ route('analysis', ['range' => '6m']) }}" class="btn {{ ($range ?? '12m') === '6m' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">6M</a>
                        <a href="{{ route('analysis', ['range' => '12m']) }}" class="btn {{ ($range ?? '12m') === '12m' ? 'btn-icf-primary text-white' : 'btn-outline-secondary' }}" style="padding: 0.35rem 0.75rem;">12M</a>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#customRangeCollapse" aria-expanded="false" aria-controls="customRangeCollapse">
                        Custom dates ▾
                    </button>
                </div>
            </div>

            <!-- Custom date range filter collapse -->
            <div class="collapse {{ ($from || $to) ? 'show' : '' }} mt-3 pt-3 border-top" id="customRangeCollapse">
                <form method="GET" action="{{ route('analysis') }}" class="p-3 bg-light rounded-3 row g-2 align-items-end border">
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
        </div>

        @if($analytics && !$analytics['isEmpty'])
            <!-- Metric Cards (Sitting directly on the page) -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="metric-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="metric-label">Period Inflow</span>
                            <span class="badge-status badge-credit" style="font-size: 0.65rem;">Credits</span>
                        </div>
                        <div class="metric-value text-success mt-1">+${{ number_format((float) $analytics['totalCredits'], 2) }}</div>
                        <div class="text-muted small mt-2" style="font-size: 0.72rem;">Total incoming capital</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="metric-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="metric-label">Period Outflow</span>
                            <span class="badge-status badge-debit" style="font-size: 0.65rem;">Debits</span>
                        </div>
                        <div class="metric-value text-danger mt-1">-${{ number_format((float) $analytics['totalDebits'], 2) }}</div>
                        <div class="text-muted small mt-2" style="font-size: 0.72rem;">Total outgoing disbursements</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="metric-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="metric-label">Net Cashflow</span>
                            <span class="badge-status {{ (float) $analytics['netChange'] >= 0 ? 'badge-active' : 'badge-disabled' }}" style="font-size: 0.65rem;">
                                {{ (float) $analytics['netChange'] >= 0 ? 'Surplus' : 'Deficit' }}
                            </span>
                        </div>
                        <div class="metric-value {{ (float) $analytics['netChange'] >= 0 ? 'text-primary' : 'text-danger' }} mt-1">
                            {{ (float) $analytics['netChange'] >= 0 ? '+' : '' }}${{ number_format((float) $analytics['netChange'], 2) }}
                        </div>
                        <div class="text-muted small mt-2" style="font-size: 0.72rem;">Net balance trajectory</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="metric-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="metric-label">Total Transactions</span>
                            <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">Activity</span>
                        </div>
                        <div class="metric-value text-dark mt-1">{{ $analytics['transactionCount'] }}</div>
                        <div class="text-muted small mt-2" style="font-size: 0.72rem;">Reconciled ledger records</div>
                    </div>
                </div>
            </div>

            <!-- Standalone Chart Cards (Sitting directly on the page) -->
            <div class="row g-4 mb-4">
                <div class="col-lg-7">
                    <div class="surface-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Credit vs Debit Timeline</h2>
                                <p class="text-secondary small mb-0">Chronological inflow and outflow trajectory</p>
                            </div>
                            <span class="badge-status badge-active" style="font-size: 0.7rem;">Timeline</span>
                        </div>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="accountTrendsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="surface-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h2 class="h5 fw-bold mb-0" style="color: var(--icf-navy);">Monthly Breakdown</h2>
                                <p class="text-secondary small mb-0">Aggregate volume comparisons</p>
                            </div>
                            <span class="badge-status badge-credit" style="font-size: 0.7rem;">Aggregated</span>
                        </div>
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="creditsDebitsBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                window.accountChartData = @json($analytics);
            </script>
        @else
            <!-- Empty State -->
            <div class="surface-card p-5 text-center mb-4">
                <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                    <svg width="24" height="24" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-3 3"/></svg>
                </div>
                <h3 class="h5 fw-bold">No activity in this period</h3>
                <p class="text-secondary small mb-3">Try adjusting your date range filter or create a transfer to populate chart data.</p>
                <a href="{{ route('analysis', ['range' => '12m']) }}" class="btn btn-sm btn-icf-secondary">Reset to 12 Months</a>
            </div>
        @endif

        <!-- Ledger Reconciliation Footnote (Standalone) -->
        <div class="surface-card p-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div class="d-flex align-items-center gap-2 text-secondary small">
                <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span><strong>Ledger verified:</strong> All transaction metrics and cashflow balances are reconciled in real-time.</span>
            </div>
            <span class="text-muted small font-monospace">{{ $account->account_reference }}</span>
        </div>
    @else
        <div class="surface-card p-5 text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem;">
                <svg width="24" height="24" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-3 3"/></svg>
            </div>
            <h2 class="h5 fw-bold">No active account assigned</h2>
            <p class="text-secondary mb-0">An administrator can assign an active investment account before analytics become available.</p>
        </div>
    @endif
</div>
</div>
@endsection
