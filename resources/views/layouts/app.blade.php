<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#070f1e">
        <meta name="description" content="ICF Investment — Private wealth management dashboard. Portfolio overview, secure simulated transfers, and institutional-grade analytics.">
        <title>{{ $title ?? 'ICF Investment' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @php
            $isPublicArea = request()->routeIs('landing', 'about', 'contact');
            $isCustomerArea = !$isPublicArea && !request()->routeIs('admin.*', 'login*', 'logout');
            $primaryAccount = auth()->check() ? auth()->user()->accounts()->where('status', 'active')->first() : null;
        @endphp
        @if($isCustomerArea)
            <style>
                body.is-customer-area,
                .is-customer-area .app-shell,
                .is-customer-area .app-content,
                .customer-section {
                    background-color: #C5C6D0 !important;
                }
            </style>
        @endif
    </head>
    <body class="{{ $isCustomerArea ? 'is-customer-area' : '' }}">

        {{-- ─── Topbar ──────────────────────────────────────────────────── --}}
        <header class="app-topbar {{ (auth()->check() && !$isPublicArea) ? 'topbar-dark' : 'topbar-landing' }}" style="background: #071f3b !important; border-bottom-color: rgba(255, 255, 255, 0.1);">
            <button class="btn-topbar d-lg-none me-3" style="padding:.4rem .6rem; background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); color: #fff;" type="button" data-shell-toggle aria-label="Toggle navigation">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            @if(auth()->check() && !$isPublicArea)
                {{-- Brand styled matching the reference header image --}}
                <a class="icf-landing-brand text-decoration-none me-xl-4 me-lg-3 flex-shrink-0" href="{{ route('dashboard') }}">
                    <span class="icf-landing-emblem" style="position: relative; display: inline-block; line-height: 1;">
                        <svg width="92" height="46" viewBox="0 0 92 46" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="icf-brand-emblem-svg">
                            <text x="6" y="37" fill="#ffffff" font-family="'Times New Roman', 'Playfair Display', 'Cinzel', Georgia, serif" font-size="38" font-weight="600" letter-spacing="1">ICF</text>
                            <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e" stroke="#071f3b" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e"/>
                        </svg>
                    </span>
                    <span class="icf-brand-divider"></span>
                    <div class="icf-brand-text-col" style="display: flex; flex-direction: column; justify-content: center;">
                        <div class="icf-brand-title">
                            ICF INVESTMENT BANK
                        </div>
                        <div class="icf-brand-sub">
                            CAPITAL &nbsp;&middot;&nbsp; TRUST &nbsp;&middot;&nbsp; GROWTH
                        </div>
                    </div>
                </a>

                {{-- Horizontal Nav Links showing sidebar pages in the header --}}
                <nav class="topbar-nav d-none d-lg-flex align-items-center me-auto" aria-label="Header navigation">
                    <a class="topbar-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span>Overview</span>
                    </a>
                    @if($primaryAccount)
                        <a class="topbar-nav-link {{ request()->routeIs('accounts.*') ? 'is-active' : '' }}" href="{{ route('accounts.show', $primaryAccount) }}">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            <span>Accounts</span>
                        </a>
                    @endif
                    <a class="topbar-nav-link {{ request()->routeIs('transfers.*') ? 'is-active' : '' }}" href="{{ route('transfers.create') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <span>Transfers</span>
                    </a>
                    <a class="topbar-nav-link {{ request()->routeIs('beneficiaries.*') ? 'is-active' : '' }}" href="{{ route('beneficiaries.index') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>Beneficiaries</span>
                    </a>
                    <a class="topbar-nav-link {{ request()->routeIs('analysis') ? 'is-active' : '' }}" href="{{ route('analysis') }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                        <span>Analytics</span>
                    </a>
                </nav>

                {{-- Right: Notifications, User Pill & Actions --}}
                <div class="ms-auto d-flex align-items-center gap-2 flex-shrink-0">
                    @if(auth()->user()->isAdmin())
                        <a class="btn-topbar-ghost" href="{{ route('admin.dashboard') }}" title="Admin Console">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span class="d-none d-xxl-inline">Admin</span>
                        </a>
                    @endif

                    <a class="topbar-nav-icon position-relative" href="{{ route('notifications.index') }}" title="Notifications">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @php $unread = auth()->user()->unreadNotificationsCount(); @endphp
                        @if($unread > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem;min-width:1.15rem;padding:.2rem .35rem;">{{ $unread }}</span>
                        @endif
                    </a>

                    <a class="topbar-user-pill text-decoration-none" href="{{ route('profile.edit') }}" title="Profile & Security">
                        @if(auth()->user()->avatarUrl())
                            <span class="topbar-user-icon overflow-hidden" style="border: 1.5px solid rgba(255, 255, 255, 0.4); background: transparent;">
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </span>
                        @else
                            <span class="topbar-user-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                        @endif
                        <span class="topbar-user-name d-none d-sm-inline">{{ auth()->user()->name }}</span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="opacity: 0.6;"><path d="M6 9l6 6 6-6"/></svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn-topbar-ghost" type="submit" title="Log out">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            <span class="d-none d-md-inline">Log out</span>
                        </button>
                    </form>
                </div>
            @else
                <a class="icf-landing-brand text-decoration-none" href="{{ route('landing') }}">
                    <span class="icf-landing-emblem" style="position: relative; display: inline-block; line-height: 1;">
                        <svg width="92" height="46" viewBox="0 0 92 46" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="icf-brand-emblem-svg">
                            <text x="6" y="37" fill="#ffffff" font-family="'Times New Roman', 'Playfair Display', 'Cinzel', Georgia, serif" font-size="38" font-weight="600" letter-spacing="1">ICF</text>
                            <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e" stroke="#071f3b" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e"/>
                        </svg>
                    </span>
                    <span class="icf-brand-divider"></span>
                    <div class="icf-brand-text-col" style="display: flex; flex-direction: column; justify-content: center;">
                        <div class="icf-brand-title">
                            ICF INVESTMENT BANK
                        </div>
                        <div class="icf-brand-sub">
                            CAPITAL &nbsp;&middot;&nbsp; TRUST &nbsp;&middot;&nbsp; GROWTH
                        </div>
                    </div>
                </a>
                <div class="ms-auto d-flex align-items-center gap-2">
                    @auth
                        <a class="btn-topbar-primary btn-topbar" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="btn-topbar-primary btn-topbar" href="{{ route('login') }}">Log in</a>
                    @endauth
                </div>
            @endif
        </header>

        {{-- ─── Shell ───────────────────────────────────────────────────── --}}
        <div class="app-shell">
            <aside class="app-sidebar" data-sidebar>
                @if(auth()->check() && !$isPublicArea)
                    {{-- User summary --}}
                    <div class="d-flex align-items-center gap-3 px-2 mb-4 pb-4" style="border-bottom:1px solid rgba(255,255,255,.07);">
                        @if(auth()->user()->avatarUrl())
                            <div style="width:2.4rem;height:2.4rem;border-radius:50%;border:2px solid rgba(255,255,255,.25);overflow:hidden;flex-shrink:0;">
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" style="width:100%;height:100%;object-fit:cover;">
                            </div>
                        @else
                            <div style="width:2.2rem;height:2.2rem;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:grid;place-items:center;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="min-width:0;">
                            <div style="font-size:.82rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                            <div style="font-size:.7rem;color:rgba(255,255,255,.4);">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>

                    <p class="sidebar-label">MENU</p>
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
                                Account Activity
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
                            Beneficiaries Management
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('analysis') ? 'is-active' : '' }}" href="{{ route('analysis') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-3 3"/></svg>
                            </span>
                            Analysis
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
                            Security Settings
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

                        <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                            @csrf
                            <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent" style="cursor: pointer; color: rgba(248, 113, 113, 0.9) !important;">
                                <span class="sidebar-icon" style="background: rgba(239, 68, 68, 0.14); color: #f87171;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                </span>
                                Sign Out
                            </button>
                        </form>
                    </nav>

                    {{-- Sidebar account pill --}}
                    <div class="sidebar-account-pill mt-4">
                        <div style="font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:.5rem;">ACCOUNT STATUS</div>
                        @if($primaryAccount ?? null)
                            <div style="font-size:.85rem;font-weight:600;color:#fff;margin-bottom:.15rem;">{{ $primaryAccount->account_reference }}</div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.4);">{{ $primaryAccount->name }}</div>
                            <div style="margin-top:.6rem;display:inline-flex;align-items:center;gap:.35rem;font-size:.68rem;font-weight:700;color:#4ade80;"><span style="width:6px;height:6px;border-radius:50%;background:#4ade80;display:inline-block;"></span>Active</div>
                        @endif
                    </div>
                @else
                    <p class="sidebar-label">Navigation</p>
                    <nav class="d-grid gap-1" aria-label="Public navigation">
                        <a class="sidebar-link {{ request()->routeIs('landing') ? 'is-active' : '' }}" href="{{ route('landing') }}">
                            <span class="sidebar-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                            Home
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('about') ? 'is-active' : '' }}" href="{{ route('about') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </span>
                            About Us
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('contact') ? 'is-active' : '' }}" href="{{ route('contact') }}">
                            <span class="sidebar-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            Contact Us
                        </a>
                        @auth
                            <a class="sidebar-link" href="{{ route('dashboard') }}">
                                <span class="sidebar-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                                @csrf
                                <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent" style="cursor: pointer; color: rgba(248, 113, 113, 0.9) !important;">
                                    <span class="sidebar-icon" style="background: rgba(239, 68, 68, 0.14); color: #f87171;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                    </span>
                                    Sign Out
                                </button>
                            </form>
                        @else
                            <a class="sidebar-link" href="{{ route('login') }}">
                                <span class="sidebar-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg></span>
                                Client Login
                            </a>
                        @endauth
                    </nav>
                @endif
            </aside>
            <div class="sidebar-backdrop d-lg-none" data-sidebar-backdrop aria-hidden="true"></div>

            {{-- ─── Content ──────────────────────────────────────────────── --}}
            <div class="app-content {{ $isCustomerArea ? 'customer-section' : '' }}">
                <main class="flex-grow-1">
                    <x-flash-message />
                    @yield('content')
                </main>
                <footer class="app-footer {{ $isPublicArea ? 'app-footer-dark' : '' }}" @if($isPublicArea) style="background: #070f1e !important; border-top: 1px solid rgba(255, 255, 255, 0.08) !important; color: rgba(255, 255, 255, 0.55) !important;" @endif>
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
