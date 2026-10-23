@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="eyebrow eyebrow-gold">✦ Administration</span>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">User &amp; Account Management</h1>
            <p class="text-secondary mb-0">Inspect client accounts, manage access states, and toggle active status.</p>
        </div>
        <a class="btn btn-sm btn-icf-secondary" href="{{ route('admin.dashboard') }}">← Back to Admin Console</a>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="surface-card p-3 mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or email..." value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <option value="customer" {{ ($role ?? '') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="administrator" {{ ($role ?? '') === 'administrator' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="disabled" {{ ($status ?? '') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-icf-primary w-100">Filter</button>
                @if($search || $role || $status)
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Users Table -->
    <div class="surface-card overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Accounts & Balances</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="small text-secondary">{{ $user->email }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $user->role === 'administrator' ? 'bg-dark' : 'bg-primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    ● {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                @if($user->accounts->isNotEmpty())
                                    <div class="d-flex flex-column gap-1">
                                        @foreach($user->accounts as $acc)
                                            <div class="d-flex align-items-center gap-2 small">
                                                <span class="font-monospace fw-semibold">{{ $acc->account_reference }}</span>:
                                                <span>${{ number_format($acc->balance, 2) }}</span>
                                                <span class="badge {{ $acc->status === 'active' ? 'bg-success-subtle text-success border border-success' : 'bg-secondary' }}" style="font-size: .65rem;">
                                                    {{ $acc->status }}
                                                </span>
                                                <form method="POST" action="{{ route('admin.accounts.toggle-status', $acc) }}" class="d-inline" onsubmit="return confirm('Change status for account {{ $acc->account_reference }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-muted" style="font-size: .7rem;" title="Toggle account status">
                                                        [{{ $acc->status === 'active' ? 'Disable' : 'Enable' }}]
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-secondary small">No accounts</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($user->id === auth()->id())
                                    <span class="badge bg-light text-muted border" title="Cannot disable your own active account">Current User</span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to {{ $user->status === 'active' ? 'DISABLE' : 'ACTIVATE' }} {{ $user->name }}? {{ $user->status === 'active' ? 'They will no longer be able to log in.' : '' }}');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            {{ $user->status === 'active' ? 'Disable User' : 'Activate User' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                No users matched your search criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
