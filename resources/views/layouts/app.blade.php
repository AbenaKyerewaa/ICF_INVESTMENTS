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
            <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('landing') }}"><span class="brand-mark">ICF</span><span class="brand-name">ICF Investment</span></a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="d-none d-sm-inline small text-secondary">Portfolio prototype</span>
                @auth
                    <a class="btn btn-sm btn-icf-secondary" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf <button class="btn btn-sm btn-icf-primary" type="submit">Log out</button></form>
                @else
                    <a class="btn btn-sm btn-icf-primary" href="{{ route('login') }}">Log in</a>
                @endauth
            </div>
        </header>
        <div class="app-shell">
            <aside class="app-sidebar" data-sidebar>
                <p class="sidebar-label">Explore</p>
                <nav class="d-grid gap-1" aria-label="Primary navigation">
                    <a class="sidebar-link is-active" href="{{ route('landing') }}"><span class="sidebar-link-icon">⌂</span>Overview</a>
                    <a class="sidebar-link" href="#experience"><span class="sidebar-link-icon">◫</span>Accounts</a>
                    <a class="sidebar-link" href="#experience"><span class="sidebar-link-icon">⇄</span>Transfers</a>
                    <a class="sidebar-link" href="#experience"><span class="sidebar-link-icon">◌</span>Activity</a>
                </nav>
                <div class="mt-5 p-3 rounded-4" style="background: rgba(255,255,255,.08);"><p class="small fw-bold mb-1 text-white">Built for clarity</p><p class="small mb-0" style="color: #b9c8e4;">A secure-looking experience with a clear simulated-data boundary.</p></div>
            </aside>
            <div class="app-content d-flex flex-column"><main class="flex-grow-1"><x-flash-message />@yield('content')</main><footer class="app-footer d-flex flex-column flex-sm-row justify-content-between gap-2"><span>© {{ now()->year }} ICF Investment · Portfolio prototype</span><span>All displayed figures and activity are DEMO/SIMULATED.</span></footer></div>
        </div>
    </body>
</html>
