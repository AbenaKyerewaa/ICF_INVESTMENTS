<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#070f1e">
        <meta name="description" content="ICF Investment — Private wealth management dashboard. Portfolio overview, secure simulated transfers, and institutional-grade analytics.">
        <title>{{ $title ?? 'ICF Investment' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        {{-- ─── Topbar ──────────────────────────────────────────────────── --}}
        <header class="app-topbar">
            <button class="btn-topbar d-lg-none me-3" style="padding:.4rem .6rem;" type="button" data-shell-toggle aria-label="Toggle navigation">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('landing') }}">
                <span class="brand-mark">ICF</span>
                <div>
                    <div class="brand-name">International Capital &amp; Finance Investments Bank</div>
                    <div class="brand-tagline">Building Wealth, Securing Futures</div>
                </div>
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="btn-topbar" href="{{ route('admin.dashboard') }}">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Admin Console
                        </a>
                    @endif
                    <a class="btn-topbar position-relative" href="{{ route('notifications.index') }}" title="Notifications">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @php $unread = auth()->user()->unreadNotificationsCount(); @endphp
                        @if($unread > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem;min-width:1.1rem;padding:.2rem .35rem;">{{ $unread }}</span>
                        @endif
                    </a>
                    <a class="btn-topbar" href="{{ route('profile.edit') }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ auth()->user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn-topbar-primary btn-topbar" type="submit">Log out</button>
                    </form>
                @else
                    <a class="btn-topbar-primary btn-topbar" href="{{ route('login') }}">Log in</a>
                @endauth
            </div>
        </header>

        {{-- ─── Shell ───────────────────────────────────────────────────── --}}
        <div class="app-shell">
            <aside class="app-sidebar" data-sidebar>
                @auth
                    {{-- User summary --}}
                    <div class="d-flex align-items-center gap-3 px-2 mb-4 pb-4" style="border-bottom:1px solid rgba(255,255,255,.07);">
                        <div style="width:2.2rem;height:2.2rem;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:grid;place-items:center;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:.82rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                            <div style="font-size:.7rem;color:rgba(255,255,255,.4);">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>

                    <p class="sidebar-label">Workspace</p>
                    <nav class="d-grid gap-1 mb-2" aria-label="Primary navigation">
                        <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            </span>
                            Dashboard
                        </a>
                        @php $primaryAccount = auth()->user()->accounts()->where('status', 'active')->first(); @endphp
                        @if($primaryAccount)
                            <a class="sidebar-link {{ request()->routeIs('accounts.*') ? 'is-active' : '' }}" href="{{ route('accounts.show', $primaryAccount) }}">
                                <span class="sidebar-icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </span>
                                Account Ledger
                            </a>
                        @endif
                        <a class="sidebar-link {{ request()->routeIs('transfers.*') ? 'is-active' : '' }}" href="{{ route('transfers.create') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                            Transfer Funds
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('beneficiaries.*') ? 'is-active' : '' }}" href="{{ route('beneficiaries.index') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </span>
                            Beneficiaries
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('notifications.*') ? 'is-active' : '' }}" href="{{ route('notifications.index') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            </span>
                            Notifications
                            @if(isset($unread) && $unread > 0)
                                <span class="ms-auto" style="background:#dc2626;color:#fff;font-size:.6rem;font-weight:700;padding:.15rem .45rem;border-radius:999px;">{{ $unread }}</span>
                            @endif
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}" href="{{ route('profile.edit') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </span>
                            Profile &amp; Security
                        </a>

                        @if(auth()->user()->isAdmin())
                            <p class="sidebar-label mt-4">Administration</p>
                            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <span class="sidebar-icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </span>
                                Admin Overview
                            </a>
                            <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}" href="{{ route('admin.users.index') }}">
                                <span class="sidebar-icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/></svg>
                                </span>
                                Manage Users
                            </a>
                            <a class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'is-active' : '' }}" href="{{ route('admin.audit-logs.index') }}">
                                <span class="sidebar-icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                </span>
                                Audit Logs
                            </a>
                        @endif
                    </nav>

                    {{-- Sidebar account pill --}}
                    <div class="sidebar-account-pill mt-4">
                        <div style="font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:.5rem;">Portfolio Status</div>
                        @if($primaryAccount ?? null)
                            <div style="font-size:.85rem;font-weight:600;color:#fff;margin-bottom:.15rem;">{{ $primaryAccount->account_reference }}</div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.4);">{{ $primaryAccount->name }}</div>
                            <div style="margin-top:.6rem;display:inline-flex;align-items:center;gap:.35rem;font-size:.68rem;font-weight:700;color:#4ade80;"><span style="width:6px;height:6px;border-radius:50%;background:#4ade80;display:inline-block;"></span>Active</div>
                        @endif
                    </div>
                @else
                    <p class="sidebar-label">Navigation</p>
                    <nav class="d-grid gap-1" aria-label="Public navigation">
                        <a class="sidebar-link is-active" href="{{ route('landing') }}">
                            <span class="sidebar-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                            Home
                        </a>
                        <a class="sidebar-link" href="{{ route('login') }}">
                            <span class="sidebar-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg></span>
                            Client Login
                        </a>
                    </nav>
                @endauth
            </aside>

            {{-- ─── Content ──────────────────────────────────────────────── --}}
            <div class="app-content">
                <main class="flex-grow-1">
                    <x-flash-message />
                    @yield('content')
                </main>
                <footer class="app-footer">
                    <span>© {{ now()->year }} ICF Investment Management Inc.</span>
                    <span class="footer-lock">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        256-bit encrypted &amp; secure
                    </span>
                </footer>
            </div>
        </div>

    </body>
</html>
