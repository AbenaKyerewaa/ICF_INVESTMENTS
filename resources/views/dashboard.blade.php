@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <span class="eyebrow">✦ Account overview & analytics</span>
            <h1 class="h2 fw-bold mt-2 mb-1">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-secondary mb-0">Your investment portfolio & account activity.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($unreadNotificationsCount > 0)
                <a class="btn btn-sm btn-outline-primary position-relative" href="{{ route('notifications.index') }}">
                    🔔 Alerts
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadNotificationsCount }}
                    </span>
                </a>
            @endif
            @if($account)
                <a class="btn btn-icf-primary" href="{{ route('transfers.create') }}">New transfer →</a>
            @endif
        </div>
    </div>

    @if($account)
        <!-- Balance & Account Highlight Card -->
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="preview-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <p class="text-white-50 small mb-1">{{ $account->name }}</p>
                                <p class="mb-0 fw-semibold">{{ $account->account_reference }}</p>
                            </div>
                            <span class="status-badge" style="background: rgba(22, 160, 133, 0.25); color: #7ef1d8;">● {{ ucfirst($account->status) }}</span>
                        </div>
                        <p class="text-white-50 small mb-1">Available balance</p>
                        <h2 class="display-6 fw-bold mb-3">${{ number_format($account->balance, 2) }} <span class="fs-6 text-white-50 fw-normal">{{ $account->currency }}</span></h2>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white-50 small text-white-50">
                        <a class="text-white text-decoration-none" href="{{ route('accounts.show', $account) }}">View full ledger history →</a>
                        <span>Verified Portfolio</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="surface-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="h6 fw-bold mb-3">Quick actions</h2>
                        <div class="d-grid gap-2">
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center" href="{{ route('transfers.create') }}">
                                <span>Transfer funds</span>
                                <span>→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center" href="{{ route('beneficiaries.index') }}">
                                <span>Manage saved beneficiaries</span>
                                <span>→</span>
                            </a>
                            <a class="btn btn-icf-secondary text-start d-flex justify-content-between align-items-center" href="{{ route('accounts.show', $account) }}">
                                <span>Download PDF statement</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top small text-secondary">
                        <span>Reconciled against {{ $analytics['transactionCount'] ?? 0 }} ledger entries.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Controls & Period Summary -->
        <div class="surface-card p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="h5 fw-bold mb-1">Activity trends & cashflow</h2>
                    <p class="text-secondary small mb-0">Aggregated server-side metrics for period {{ $analytics['startDate'] ?? '' }} to {{ $analytics['endDate'] ?? '' }}</p>
                </div>
                <!-- Date-Range Selector Controls -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Date range selector">
                        <a href="{{ route('dashboard', ['range' => '30d']) }}" class="btn {{ ($range ?? '12m') === '30d' ? 'btn-primary' : 'btn-outline-secondary' }}">30D</a>
                        <a href="{{ route('dashboard', ['range' => '90d']) }}" class="btn {{ ($range ?? '12m') === '90d' ? 'btn-primary' : 'btn-outline-secondary' }}">90D</a>
                        <a href="{{ route('dashboard', ['range' => '6m']) }}" class="btn {{ ($range ?? '12m') === '6m' ? 'btn-primary' : 'btn-outline-secondary' }}">6M</a>
                        <a href="{{ route('dashboard', ['range' => '12m']) }}" class="btn {{ ($range ?? '12m') === '12m' ? 'btn-primary' : 'btn-outline-secondary' }}">12M</a>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#customRangeCollapse" aria-expanded="false" aria-controls="customRangeCollapse">
                        Custom dates ▾
                    </button>
                </div>
            </div>

            <!-- Custom date range filter collapse -->
            <div class="collapse {{ ($from || $to) ? 'show' : '' }} mb-4" id="customRangeCollapse">
                <form method="GET" action="{{ route('dashboard') }}" class="p-3 bg-light rounded-3 row g-2 align-items-end">
                    <div class="col-sm-5">
                        <label class="form-label small text-secondary mb-1">From Date</label>
                        <input type="date" name="from" class="form-control form-control-sm" value="{{ $from ?? '' }}" required>
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label small text-secondary mb-1">To Date</label>
                        <input type="date" name="to" class="form-control form-control-sm" value="{{ $to ?? '' }}" required>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-sm btn-icf-primary w-100">Apply</button>
                    </div>
                </form>
            </div>

            @if($analytics && !$analytics['isEmpty'])
                <!-- Period Aggregate Metric Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="p-3 rounded-3 border bg-light">
                            <span class="small text-secondary fw-semibold">Period Inflow (Credits)</span>
                            <div class="h5 fw-bold text-success mb-0 mt-1">+${{ number_format((float) $analytics['totalCredits'], 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="p-3 rounded-3 border bg-light">
                            <span class="small text-secondary fw-semibold">Period Outflow (Debits)</span>
                            <div class="h5 fw-bold text-danger mb-0 mt-1">-${{ number_format((float) $analytics['totalDebits'], 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="p-3 rounded-3 border bg-light">
                            <span class="small text-secondary fw-semibold">Net Cashflow</span>
                            <div class="h5 fw-bold {{ (float) $analytics['netChange'] >= 0 ? 'text-primary' : 'text-danger' }} mb-0 mt-1">
                                {{ (float) $analytics['netChange'] >= 0 ? '+' : '' }}${{ number_format((float) $analytics['netChange'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="p-3 rounded-3 border bg-light">
                            <span class="small text-secondary fw-semibold">Total Transactions</span>
                            <div class="h5 fw-bold text-dark mb-0 mt-1">{{ $analytics['transactionCount'] }} records</div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Chart.js Visualizations -->
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="border rounded-3 p-3">
                            <h2 class="h6 fw-bold mb-3">Credit vs Debit Timeline</h2>
                            <div style="position: relative; height: 260px; width: 100%;">
                                <canvas id="accountTrendsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="border rounded-3 p-3">
                            <h2 class="h6 fw-bold mb-3">Monthly Cashflow Breakdown</h2>
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
                    <div class="feature-icon mx-auto mb-2" style="width: 3rem; height: 3rem; font-size: 1.25rem;">📊</div>
                    <h2 class="h6 fw-bold">No activity in this period</h2>
                    <p class="text-secondary small mb-3">Try adjusting your date range filter or create a transfer to populate chart data.</p>
                    <a href="{{ route('dashboard', ['range' => '12m']) }}" class="btn btn-sm btn-outline-primary">Reset to 12 Months</a>
                </div>
            @endif

            <div class="alert alert-light border mt-4 mb-0 small text-secondary d-flex align-items-center gap-2">
                <span>🔒</span>
                <span><strong>Ledger verified:</strong> All transaction metrics and cashflow balances are reconciled in real-time with double-entry accounting.</span>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="surface-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Recent ledger entries</h2>
                <a class="btn btn-sm btn-icf-secondary" href="{{ route('accounts.show', $account) }}">View all transactions</a>
            </div>
            @forelse($recentEntries as $entry)
                <div class="d-flex justify-content-between align-items-center border-top py-3">
                    <div>
                        <strong>{{ $entry->description }}</strong><br>
                        <small class="text-secondary">{{ $entry->occurred_at->format('M j, Y') }} · {{ $entry->entry_reference }}</small>
                    </div>
                    <strong class="{{ $entry->entry_type === 'credit' ? 'text-success' : 'text-danger' }}">
                        {{ $entry->entry_type === 'credit' ? '+' : '-' }}${{ number_format($entry->amount, 2) }}
                    </strong>
                </div>
            @empty
                <p class="text-secondary mb-0">No activity recorded yet.</p>
            @endforelse
        </div>
    @else
        <div class="surface-card p-5 text-center">
            <h2 class="h5 fw-bold">No active account assigned</h2>
            <p class="text-secondary mb-0">An administrator can assign an active investment account before activity becomes available.</p>
        </div>
    @endif
</div>
@endsection
