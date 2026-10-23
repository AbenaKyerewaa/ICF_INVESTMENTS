<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0c1f3d">
        <title>{{ $title ?? 'ICF Investment' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="app-topbar d-flex align-items-center px-3 px-lg-4">
            <button class="btn btn-light border d-lg-none me-2" type="button" data-shell-toggle aria-label="Toggle navigation">☰</button>
            <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('landing') }}">
                <span class="brand-mark">ICF</span>
                <span class="brand-name">ICF Investment</span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="d-none d-sm-inline small text-secondary">Private Wealth & Asset Management</span>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="btn btn-sm btn-outline-dark fw-bold" href="{{ route('admin.dashboard') }}">Admin Console</a>
                    @endif
                    <a class="btn btn-sm btn-light border position-relative" href="{{ route('notifications.index') }}" title="Notifications">
                        🔔
                        @php $unread = auth()->user()->unreadNotificationsCount(); @endphp
                        @if($unread > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                    <a class="btn btn-sm btn-icf-secondary" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-icf-primary" type="submit">Log out</button>
                    </form>
                @else
                    <a class="btn btn-sm btn-icf-primary" href="{{ route('login') }}">Log in</a>
                @endauth
            </div>
        </header>
        <div class="app-shell">
            <aside class="app-sidebar" data-sidebar>
                <p class="sidebar-label">Navigation</p>
                <nav class="d-grid gap-1" aria-label="Primary navigation">
                    @auth
                        <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="sidebar-link-icon">⌂</span>Dashboard
                        </a>
                        @php $primaryAccount = auth()->user()->accounts()->where('status', 'active')->first(); @endphp
                        @if($primaryAccount)
                            <a class="sidebar-link {{ request()->routeIs('accounts.*') ? 'is-active' : '' }}" href="{{ route('accounts.show', $primaryAccount) }}">
                                <span class="sidebar-link-icon">◫</span>Account Ledger
                            </a>
                        @endif
                        <a class="sidebar-link {{ request()->routeIs('transfers.*') ? 'is-active' : '' }}" href="{{ route('transfers.create') }}">
                            <span class="sidebar-link-icon">⇄</span>Transfer Funds
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('beneficiaries.*') ? 'is-active' : '' }}" href="{{ route('beneficiaries.index') }}">
                            <span class="sidebar-link-icon">👥</span>Beneficiaries
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('notifications.*') ? 'is-active' : '' }}" href="{{ route('notifications.index') }}">
                            <span class="sidebar-link-icon">🔔</span>Notifications
                            @if(isset($unread) && $unread > 0)
                                <span class="badge bg-danger ms-auto" style="font-size: .65rem;">{{ $unread }}</span>
                            @endif
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}" href="{{ route('profile.edit') }}">
                            <span class="sidebar-link-icon">⚙</span>Profile & Security
                        </a>

                        @if(auth()->user()->isAdmin())
                            <p class="sidebar-label mt-4">Administrator</p>
                            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <span class="sidebar-link-icon">🛡</span>Admin Overview
                            </a>
                            <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}" href="{{ route('admin.users.index') }}">
                                <span class="sidebar-link-icon">👤</span>Manage Users
                            </a>
                            <a class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'is-active' : '' }}" href="{{ route('admin.audit-logs.index') }}">
                                <span class="sidebar-link-icon">📋</span>Audit Logs
                            </a>
                        @endif
                    @else
                        <a class="sidebar-link is-active" href="{{ route('landing') }}"><span class="sidebar-link-icon">⌂</span>Home</a>
                        <a class="sidebar-link" href="{{ route('landing') }}#experience"><span class="sidebar-link-icon">◫</span>Experience</a>
                        <a class="sidebar-link" href="{{ route('login') }}"><span class="sidebar-link-icon">➜</span>Log In</a>
                    @endauth
                </nav>
                <div class="mt-5 p-3 rounded-4" style="background: rgba(255,255,255,.08);">
                    <p class="small fw-bold mb-1 text-white">ICF Wealth Solutions</p>
                    <p class="small mb-0" style="color: #b9c8e4;">Enterprise-grade investment management, asset allocation, and liquidity solutions.</p>
                </div>
            </aside>
            <div class="app-content d-flex flex-column">
                <main class="flex-grow-1">
                    <x-flash-message />
                    @yield('content')
                </main>
                <footer class="app-footer d-flex flex-column flex-sm-row justify-content-between gap-2">
                    <span>© {{ now()->year }} ICF Investment Management Inc. All rights reserved.</span>
                    <span>Secure 256-bit encrypted banking environment.</span>
                </footer>
            </div>
        </div>
    </body>
</html>
