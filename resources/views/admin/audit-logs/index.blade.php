@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Security &amp; Compliance</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Audit Log Viewer</h1>
            <p class="text-secondary mb-0">Immutable record of security, authentication, transaction, and admin events.</p>
        </div>
        <a class="btn btn-sm btn-icf-secondary" href="{{ route('admin.dashboard') }}">← Back to Admin Console</a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="surface-card p-3 mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-secondary mb-1">Action Type</label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    @foreach($distinctActions as $act)
                        <option value="{{ $act }}" {{ ($action ?? '') === $act ? 'selected' : '' }}>{{ $act }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-secondary mb-1">Keyword Search</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Actor, email, IP..." value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-secondary mb-1">From Date</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ $from ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-secondary mb-1">To Date</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ $to ?? '' }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-icf-primary w-100">Filter</button>
                @if($action || $search || $from || $to)
                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Audit Logs Table -->
    <div class="surface-card overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Timestamp</th>
                        <th>Actor</th>
                        <th>Action</th>
                        <th>Target</th>
                        <th>IP Address</th>
                        <th class="pe-4">Metadata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                        <tr>
                            <td class="ps-4 text-nowrap">
                                <div>{{ $log->occurred_at->format('Y-m-d H:i:s') }}</div>
                                <small class="text-secondary">{{ $log->occurred_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                @if($log->actor)
                                    <div class="fw-semibold text-dark">{{ $log->actor->name }}</div>
                                    <small class="text-secondary">{{ $log->actor->email }}</small>
                                @else
                                    <span class="text-secondary fst-italic">Unauthenticated / System</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ str_contains($log->action, 'failed') ? 'bg-danger' : (str_contains($log->action, 'admin') ? 'bg-dark' : (str_contains($log->action, 'transfer') ? 'bg-success' : 'bg-primary')) }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td>
                                @if($log->target_type)
                                    <span class="font-monospace text-muted">{{ $log->target_type }} #{{ $log->target_id }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="font-monospace text-secondary">{{ $log->ip_address ?? '—' }}</span>
                            </td>
                            <td class="pe-4">
                                @if(!empty($log->metadata))
                                    <details>
                                        <summary class="text-primary small" style="cursor: pointer;">Inspect payload</summary>
                                        <pre class="bg-light p-2 rounded small mt-1 mb-0 border" style="font-size: 0.75rem; max-width: 280px; overflow-x: auto;">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </details>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                No audit log records found matching your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($auditLogs->hasPages())
        <div class="mt-4">
            {{ $auditLogs->links() }}
        </div>
    @endif
</div>
@endsection
