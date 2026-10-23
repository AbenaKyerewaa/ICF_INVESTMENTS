@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Administrative Console</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">System Overview</h1>
            <p class="text-secondary mb-0">Authorized administration tools, user management, and event audit trails.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-sm btn-icf-secondary" href="{{ route('admin.users.index') }}">Manage Users</a>
            <a class="btn btn-sm btn-icf-secondary" href="{{ route('admin.audit-logs.index') }}">View Audit Logs</a>
        </div>
    </div>

    <!-- Admin Top KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="surface-card p-3 h-100">
                <span class="metric-label">Total Users</span>
                <div class="metric-value my-1">{{ $totalUsers }}</div>
                <div class="small text-secondary">
                    <span class="text-success fw-bold">{{ $activeUsers }} active</span> ·
                    <span class="text-danger">{{ $disabledUsers }} disabled</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="surface-card p-3 h-100">
                <span class="metric-label">Total Accounts</span>
                <div class="metric-value my-1">{{ $totalAccounts }}</div>
                <div class="small text-secondary">
                    <span class="text-success fw-bold">{{ $activeAccounts }} active</span> accounts
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="surface-card p-3 h-100">
                <span class="metric-label">Total Client Balance</span>
                <div class="metric-value my-1">${{ number_format((float) $totalSimulatedBalance, 2) }}</div>
                <div class="small text-secondary">Across client accounts (USD)</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="surface-card p-3 h-100">
                <span class="metric-label">Completed Transfers</span>
                <div class="metric-value my-1">{{ $totalTransfers }}</div>
                <div class="small text-secondary">${{ number_format((float) $totalTransferredVolume, 2) }} total volume</div>
            </div>
        </div>
    </div>

    <!-- Master Login OTP Card for Admin -->
    <div class="surface-card p-4 mb-4" style="background: linear-gradient(135deg, #070f1e 0%, #0d1b33 100%); color: #fff; border-color: rgba(201, 168, 76, 0.35); box-shadow: var(--shadow-lg);">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow eyebrow-gold mb-2">Master Authentication Gate</span>
                <h2 class="h5 fw-bold text-white mb-1">System Master Login OTP</h2>
                <p class="text-white-50 small mb-0">This is the constant security code required for all clients and administrators to open their accounts after entering credentials.</p>
            </div>
            <div class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="background: rgba(18, 32, 64, 0.85); border-color: rgba(255,255,255,0.15) !important;">
                <div class="text-end">
                    <div class="small text-white-50" style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em;">Constant Access OTP</div>
                    <div class="font-monospace fw-bold fs-3 mb-0" style="color: var(--icf-gold); letter-spacing: 0.25em;">{{ $loginOtp }}</div>
                </div>
                <span class="badge-status badge-active flex-shrink-0" style="background: rgba(34, 197, 94, 0.2); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.3);">Active Key</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Audit Events -->
        <div class="col-lg-7">
            <div class="surface-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">Recent audit activity</h2>
                    <a class="btn btn-sm btn-link p-0 text-decoration-none" href="{{ route('admin.audit-logs.index') }}">View all logs →</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentAuditLogs as $log)
                        <div class="list-group-item px-0 py-2 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge {{ str_contains($log->action, 'failed') ? 'bg-danger' : (str_contains($log->action, 'admin') ? 'bg-dark' : 'bg-primary') }} me-2">
                                    {{ $log->action }}
                                </span>
                                <small class="text-dark fw-semibold">{{ $log->actor?->name ?? 'System/Guest' }}</small>
                                <span class="text-secondary small d-none d-md-inline ms-1">({{ $log->ip_address ?? 'unknown IP' }})</span>
                            </div>
                            <small class="text-secondary">{{ $log->occurred_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0 py-3">No audit activity logged yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-5">
            <div class="surface-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">User directory snapshot</h2>
                    <a class="btn btn-sm btn-link p-0 text-decoration-none" href="{{ route('admin.users.index') }}">All users →</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentUsers as $user)
                        <div class="list-group-item px-0 py-2 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                <small class="text-secondary">{{ $user->email }} · {{ ucfirst($user->role) }}</small>
                            </div>
                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0 py-3">No users found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="p-3 bg-light rounded-3 border mt-4 small text-secondary d-flex align-items-center gap-2">
        <svg width="18" height="18" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span><strong>Admin Security Note:</strong> Administrative operations are strictly restricted to authorized administrator roles. All status changes, authentication attempts, and operations produce permanent append-only audit log entries with safe metadata.</span>
    </div>
</div>
@endsection
