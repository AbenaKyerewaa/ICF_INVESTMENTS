<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#070f1e">
    <meta name="description" content="ICF Investment Bank — Secure client portal sign in.">
    <title>{{ $title ?? 'Client Sign In' }} — ICF Investment Bank</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Auth Layout ─────────────────────────────────────────────── */
        html, body { height: 100%; margin: 0; padding: 0; }

        .icf-auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f4fa;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        /* ── Top nav bar ────────────────────────────────────────────── */
        .icf-auth-topbar {
            height: 64px;
            background: #061228;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            flex-shrink: 0;
        }
        .icf-auth-topbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }
        .icf-auth-logo-box {
            width: 52px;
            height: 52px;
            border: 2.5px solid #c9a84c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -.02em;
            font-style: italic;
        }
        .icf-auth-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .icf-auth-logo-text .line1 {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .09em;
            color: #fff;
            text-transform: uppercase;
        }
        .icf-auth-logo-text .line2 {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .09em;
            color: #fff;
            text-transform: uppercase;
        }
        .icf-auth-logo-text .line3 {
            font-size: .58rem;
            font-weight: 600;
            letter-spacing: .14em;
            color: #c9a84c;
            text-transform: uppercase;
            margin-top: .1rem;
        }
        .icf-auth-topbar-tagline {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .22em;
            color: rgba(255,255,255,.55);
            text-transform: uppercase;
        }
        .icf-auth-topbar-tagline span { color: rgba(255,255,255,.3); margin: 0 .5rem; }

        /* ── Main split ─────────────────────────────────────────────── */
        .icf-auth-body {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 520px;
            min-height: 0;
        }

        /* ── Left hero panel ─────────────────────────────────────────── */
        .icf-auth-hero {
            position: relative;
            overflow: hidden;
            background: #061228;
        }
        .icf-auth-hero-img {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=85&auto=format&fit=crop');
            background-size: cover;
            background-position: center 30%;
            opacity: .72;
        }
        .icf-auth-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to right,
                rgba(6, 18, 40, 0.35) 0%,
                rgba(6, 18, 40, 0.15) 60%,
                rgba(6, 18, 40, 0.55) 100%
            );
        }
        .icf-auth-hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            height: 100%;
            padding: 3.5rem;
        }
        .icf-auth-hero-rule {
            width: 2.5rem;
            height: 3px;
            background: #c9a84c;
            margin-bottom: 1.4rem;
        }
        .icf-auth-hero-headline {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
            letter-spacing: -.02em;
        }
        .icf-auth-hero-sub {
            font-size: .95rem;
            color: rgba(255,255,255,.75);
            line-height: 1.65;
            max-width: 380px;
        }

        /* ── Right card panel ───────────────────────────────────────── */
        .icf-auth-panel {
            background: #f0f4fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 2.5rem;
        }
        .icf-auth-card {
            background: #fff;
            border-radius: 1.1rem;
            box-shadow: 0 24px 64px rgba(6,18,40,.13), 0 2px 8px rgba(6,18,40,.07);
            padding: 2.5rem 2.25rem;
            width: 100%;
            max-width: 400px;
        }

        /* Card brand mark */
        .icf-card-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .icf-card-logo {
            font-size: 1.6rem;
            font-weight: 900;
            font-style: italic;
            color: #061228;
            letter-spacing: -.04em;
            line-height: 1;
            position: relative;
            display: inline-block;
            margin-bottom: .1rem;
        }
        .icf-card-logo::after {
            content: '';
            position: absolute;
            bottom: .15rem;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: #c9a84c;
        }

        .icf-card-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #061228;
            margin-bottom: .25rem;
            text-align: center;
        }
        .icf-card-subtitle {
            font-size: .82rem;
            color: #64748b;
            text-align: center;
        }

        /* Input rows with icon prefix */
        .icf-field {
            display: flex;
            align-items: stretch;
            border: 1.5px solid #d1d9e8;
            border-radius: .55rem;
            overflow: hidden;
            transition: border-color .18s, box-shadow .18s;
            background: #fff;
        }
        .icf-field:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .icf-field.is-invalid {
            border-color: #dc2626;
        }
        .icf-field-icon {
            width: 44px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-right: 1.5px solid #e4eaf3;
            color: #94a3b8;
        }
        .icf-field input {
            flex: 1;
            border: none;
            outline: none;
            padding: .7rem .85rem;
            font-size: .88rem;
            color: #0f172a;
            background: transparent;
            font-family: inherit;
        }
        .icf-field input::placeholder { color: #a0aec0; }
        .icf-field-toggle {
            width: 44px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            transition: color .15s;
        }
        .icf-field-toggle:hover { color: #2563eb; }

        .icf-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .45rem;
        }

        /* Remember / forgot row */
        .icf-remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1rem 0 1.3rem;
        }
        .icf-check-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }
        .icf-check-box {
            width: 17px;
            height: 17px;
            border: 2px solid #2563eb;
            border-radius: .25rem;
            background: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .icf-check-box svg { display: block; }
        .icf-forgot {
            font-size: .8rem;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .icf-forgot:hover { text-decoration: underline; }

        /* Sign In button */
        .icf-signin-btn {
            width: 100%;
            padding: .9rem 1rem;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: .6rem;
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            cursor: pointer;
            transition: background .18s, transform .12s, box-shadow .18s;
            font-family: inherit;
        }
        .icf-signin-btn:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 24px rgba(37,99,235,.35);
            transform: translateY(-1px);
        }
        .icf-signin-btn:active { transform: translateY(0); }

        /* Security notice */
        .icf-security-note {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            margin-top: 1.4rem;
            padding: .85rem;
            background: #f8fafc;
            border-radius: .55rem;
            border: 1px solid #e4eaf3;
        }
        .icf-security-note p {
            font-size: .75rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* Validation */
        .icf-error { font-size: .75rem; color: #dc2626; margin-top: .35rem; }

        /* ── Footer ────────────────────────────────────────────────── */
        .icf-auth-footer {
            height: 56px;
            background: #061228;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            flex-shrink: 0;
        }
        .icf-auth-footer-left {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }
        .icf-auth-footer-logo {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
        }
        .icf-auth-footer-logo-box {
            width: 36px;
            height: 36px;
            border: 1.5px solid #c9a84c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 900;
            color: #fff;
            font-style: italic;
        }
        .icf-auth-footer-logo-text { line-height: 1.2; }
        .icf-auth-footer-logo-text .fl1 {
            font-size: .55rem;
            font-weight: 700;
            letter-spacing: .09em;
            color: rgba(255,255,255,.7);
            text-transform: uppercase;
        }
        .icf-auth-footer-logo-text .fl2 {
            font-size: .5rem;
            font-weight: 600;
            letter-spacing: .12em;
            color: #c9a84c;
            text-transform: uppercase;
        }
        .icf-auth-footer-divider {
            width: 1px;
            height: 24px;
            background: rgba(255,255,255,.15);
        }
        .icf-auth-footer-tag {
            font-size: .62rem;
            font-weight: 600;
            letter-spacing: .16em;
            color: rgba(255,255,255,.38);
            text-transform: uppercase;
        }
        .icf-auth-footer-links {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }
        .icf-auth-footer-links a {
            font-size: .7rem;
            color: rgba(255,255,255,.45);
            text-decoration: none;
            font-weight: 500;
            transition: color .15s;
        }
        .icf-auth-footer-links a:hover { color: rgba(255,255,255,.85); }
        .icf-auth-footer-links span { color: rgba(255,255,255,.2); }

        /* ── Responsive ─────────────────────────────────────────────── */
        @media (max-width: 820px) {
            .icf-auth-body { grid-template-columns: 1fr; }
            .icf-auth-hero { display: none; }
            .icf-auth-panel { padding: 1.5rem 1rem; }
            .icf-auth-topbar-tagline { display: none; }
            .icf-auth-footer-tag { display: none; }
            .icf-auth-footer-divider { display: none; }
        }
    </style>
</head>
<body>
<div class="icf-auth-page">

    {{-- ── Top nav bar ──────────────────────────────────────────── --}}
    <header class="icf-auth-topbar">
        <a class="icf-auth-topbar-brand" href="{{ route('landing') }}">
            <div class="icf-auth-logo-box">ICF</div>
            <div class="icf-auth-logo-text">
                <span class="line1">International Capital</span>
                <span class="line2">and Finance</span>
                <span class="line3">Investment Bank</span>
            </div>
        </a>
        <div class="icf-auth-topbar-tagline">
            Trust <span>/</span> Growth <span>/</span> Opportunity
        </div>
    </header>

    {{-- ── Main split ───────────────────────────────────────────── --}}
    <div class="icf-auth-body">

        {{-- Left hero --}}
        <div class="icf-auth-hero">
            <div class="icf-auth-hero-img"></div>
            <div class="icf-auth-hero-overlay"></div>
            <div class="icf-auth-hero-content">
                <div class="icf-auth-hero-rule"></div>
                <h2 class="icf-auth-hero-headline">Your Financial<br>Goals. Our Priority.</h2>
                <p class="icf-auth-hero-sub">Secure access to your accounts, investments and financial services — all in one place.</p>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="icf-auth-panel">
            <div class="icf-auth-card">

                {{-- Card brand --}}
                <div class="icf-card-brand">
                    <span class="icf-card-logo">ICF</span>
                </div>
                <h1 class="icf-card-title">Client Sign In</h1>
                <p class="icf-card-subtitle">Access your secure client portal.</p>

                @if ($errors->any())
                    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:.5rem;padding:.75rem 1rem;margin:1rem 0;font-size:.8rem;color:#dc2626;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" style="margin-top: 1.5rem;">
                    @csrf

                    {{-- Email --}}
                    <div style="margin-bottom: 1rem;">
                        <label class="icf-label" for="email">Email Address</label>
                        <div class="icf-field @error('email') is-invalid @enderror">
                            <div class="icf-field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                                placeholder="name@company.com"
                            >
                        </div>
                        @error('email')
                            <div class="icf-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div style="margin-bottom: 0;">
                        <label class="icf-label" for="password">Password</label>
                        <div class="icf-field @error('password') is-invalid @enderror">
                            <div class="icf-field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="Enter your password"
                            >
                            <button type="button" class="icf-field-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                <svg id="eyeIcon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="icf-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember / Forgot --}}
                    <div class="icf-remember-row">
                        <label class="icf-check-label">
                            <input type="checkbox" name="remember" id="remember" value="1" checked style="display:none;">
                            <span class="icf-check-box" id="checkBox">
                                <svg width="10" height="10" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            Remember this device
                        </label>
                        <a href="#" class="icf-forgot">Forgot password?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="icf-signin-btn" id="signinBtn">
                        Sign In
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>

                </form>

                {{-- Security note --}}
                <div class="icf-security-note">
                    <svg width="17" height="17" fill="none" stroke="#c9a84c" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:.05rem;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <p>Your security matters. We use industry-standard encryption to protect your information.</p>
                </div>

            </div>
        </div>

    </div>

    {{-- ── Footer ─────────────────────────────────────────────────── --}}
    <footer class="icf-auth-footer">
        <div class="icf-auth-footer-left">
            <a class="icf-auth-footer-logo" href="{{ route('landing') }}">
                <div class="icf-auth-footer-logo-box">ICF</div>
                <div class="icf-auth-footer-logo-text">
                    <div class="fl1">International Capital and Finance</div>
                    <div class="fl2">Investment Bank</div>
                </div>
            </a>
            <div class="icf-auth-footer-divider"></div>
            <span class="icf-auth-footer-tag">Professional Service. Lasting Relationships.</span>
        </div>
        <div class="icf-auth-footer-links">
            <a href="#">Privacy</a>
            <span>|</span>
            <a href="#">Security</a>
            <span>|</span>
            <a href="#">Contact Support</a>
        </div>
    </footer>

</div>

<script>
    // Password show/hide toggle
    const toggleBtn = document.getElementById('togglePassword');
    const pwInput   = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isText = pwInput.type === 'text';
            pwInput.type = isText ? 'password' : 'text';
            eyeIcon.innerHTML = isText
                ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
                : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        });
    }

    // Remember checkbox toggle
    const rememberInput = document.getElementById('remember');
    const checkBox      = document.getElementById('checkBox');
    if (checkBox) {
        checkBox.addEventListener('click', () => {
            rememberInput.checked = !rememberInput.checked;
            checkBox.style.background    = rememberInput.checked ? '#2563eb' : '#fff';
            checkBox.style.borderColor   = '#2563eb';
            checkBox.querySelector('svg').style.opacity = rememberInput.checked ? '1' : '0';
        });
    }
</script>
</body>
</html>
