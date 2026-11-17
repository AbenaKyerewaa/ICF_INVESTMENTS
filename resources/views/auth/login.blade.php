<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#061228">
    <meta name="description" content="ICF Investment Bank — Secure client portal sign in.">
    <title>Client Sign In — ICF Investment Bank</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Reset for standalone page ───────────────────────────── */
        html, body { height: 100%; margin: 0; padding: 0; }

        .icf-auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #eef2f9;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        /* ── Top nav bar ─────────────────────────────────────────── */
        .icf-auth-topbar {
            height: 76px;
            background: #071f3b;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            flex-shrink: 0;
            z-index: 10;
        }
        .icf-auth-topbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }
        .icf-auth-logo-box {
            width: 50px;
            height: 50px;
            border: 2px solid #c9a84c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -.02em;
            font-style: italic;
        }
        .icf-auth-logo-text { display: flex; flex-direction: column; line-height: 1.25; }
        .icf-auth-logo-text .t1,
        .icf-auth-logo-text .t2 { font-size: .6rem; font-weight: 700; letter-spacing: .09em; color: #fff; text-transform: uppercase; }
        .icf-auth-logo-text .t3 { font-size: .56rem; font-weight: 700; letter-spacing: .15em; color: #c9a84c; text-transform: uppercase; margin-top: .15rem; }

        .icf-auth-topbar-tagline {
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: .22em;
            color: rgba(255,255,255,.45);
            text-transform: uppercase;
        }
        .icf-auth-topbar-tagline .sep { color: rgba(255,255,255,.2); margin: 0 .45rem; }

        /* ── Main split ──────────────────────────────────────────── */
        .icf-auth-body {
            flex: 1;
            display: grid;
            grid-template-columns: 7fr 3fr;
            min-height: 0;
        }

        /* ── Left hero panel ──────────────────────────────────────── */
        .icf-auth-hero {
            position: relative;
            overflow: hidden;
            min-height: 480px;
        }
        .icf-auth-hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=85&auto=format&fit=crop');
            background-size: cover;
            background-position: center 35%;
        }
        .icf-auth-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                105deg,
                rgba(6,18,40,.28) 0%,
                rgba(6,18,40,.10) 55%,
                rgba(6,18,40,.62) 100%
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
        .icf-hero-rule {
            width: 2.4rem;
            height: 3px;
            background: #c9a84c;
            margin-bottom: 1.3rem;
        }
        .icf-hero-headline {
            font-size: clamp(1.9rem, 3.5vw, 2.6rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -.025em;
            margin-bottom: .9rem;
        }
        .icf-hero-sub {
            font-size: .92rem;
            color: rgba(255,255,255,.75);
            line-height: 1.65;
            max-width: 360px;
        }

        /* ── Right card panel ─────────────────────────────────────── */
        .icf-auth-panel {
            background: #eef2f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
        }
        .icf-auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow:
                0 2px 8px rgba(6,18,40,.06),
                0 16px 48px rgba(6,18,40,.12);
            padding: 2.5rem 2.25rem;
            width: 100%;
            max-width: 390px;
        }

        /* Card logo */
        .icf-clogo {
            text-align: center;
            margin-bottom: 1.1rem;
        }
        .icf-clogo-mark {
            display: inline-block;
            font-size: 1.7rem;
            font-weight: 900;
            font-style: italic;
            color: #061228;
            letter-spacing: -.04em;
            line-height: 1;
            position: relative;
            padding-bottom: .3rem;
        }
        .icf-clogo-mark::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 18%;
            right: 18%;
            height: 2.5px;
            background: #c9a84c;
        }

        .icf-card-h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #061228;
            text-align: center;
            margin: 0 0 .3rem;
        }
        .icf-card-sub {
            font-size: .8rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 1.6rem;
        }

        /* Field */
        .icf-f-wrap { margin-bottom: .9rem; }
        .icf-f-label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .38rem;
        }
        .icf-f-row {
            display: flex;
            align-items: stretch;
            border: 1.5px solid #d1d9e8;
            border-radius: .5rem;
            overflow: hidden;
            transition: border-color .16s, box-shadow .16s;
            background: #fff;
        }
        .icf-f-row:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.11);
        }
        .icf-f-row.err { border-color: #ef4444; }
        .icf-f-ico {
            width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-right: 1.5px solid #e4eaf3;
            color: #94a3b8;
            flex-shrink: 0;
        }
        .icf-f-row input {
            flex: 1;
            border: none;
            outline: none;
            padding: .68rem .8rem;
            font-size: .86rem;
            color: #0f172a;
            background: transparent;
            font-family: inherit;
        }
        .icf-f-row input::placeholder { color: #b0baca; }
        .icf-f-eye {
            width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            transition: color .14s;
        }
        .icf-f-eye:hover { color: #2563eb; }
        .icf-f-err { font-size: .72rem; color: #ef4444; margin-top: .3rem; }

        /* Remember / Forgot row */
        .icf-row-rf {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: .9rem 0 1.2rem;
        }
        .icf-check-lbl {
            display: flex;
            align-items: center;
            gap: .45rem;
            font-size: .78rem;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }
        .icf-chk {
            width: 17px;
            height: 17px;
            border-radius: .28rem;
            background: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .14s;
        }
        .icf-chk.off { background: #fff; border: 2px solid #d1d9e8; }
        .icf-chk svg { display: block; }
        .icf-chk.off svg { opacity: 0; }
        .icf-forgot {
            font-size: .78rem;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .icf-forgot:hover { text-decoration: underline; }

        /* Sign In button */
        .icf-btn-signin {
            width: 100%;
            padding: .88rem 1rem;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: .55rem;
            font-size: .92rem;
            font-weight: 700;
            letter-spacing: .02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            cursor: pointer;
            transition: background .17s, box-shadow .17s, transform .1s;
            font-family: inherit;
        }
        .icf-btn-signin:hover {
            background: #1d4ed8;
            box-shadow: 0 8px 28px rgba(37,99,235,.38);
            transform: translateY(-1px);
        }
        .icf-btn-signin:active { transform: translateY(0); }

        /* Security note */
        .icf-sec-note {
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            margin-top: 1.3rem;
            padding: .75rem .9rem;
            background: #f8fafc;
            border-radius: .5rem;
            border: 1px solid #e4eaf3;
        }
        .icf-sec-note p {
            font-size: .72rem;
            color: #64748b;
            margin: 0;
            line-height: 1.55;
            text-align: center;
            flex: 1;
        }

        /* Alert error banner */
        .icf-alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: .5rem;
            padding: .7rem .9rem;
            margin-bottom: 1rem;
            font-size: .78rem;
            color: #dc2626;
        }

        /* ── Footer ──────────────────────────────────────────────── */
        .icf-auth-footer {
            height: 54px;
            background: #061228;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            flex-shrink: 0;
        }
        .icf-af-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .icf-af-logo {
            display: flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
        }
        .icf-af-logobox {
            width: 34px;
            height: 34px;
            border: 1.5px solid #c9a84c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 900;
            color: #fff;
            font-style: italic;
        }
        .icf-af-logotext { line-height: 1.2; }
        .icf-af-logotext .af1 { font-size: .52rem; font-weight: 700; letter-spacing: .09em; color: rgba(255,255,255,.65); text-transform: uppercase; }
        .icf-af-logotext .af2 { font-size: .48rem; font-weight: 700; letter-spacing: .13em; color: #c9a84c; text-transform: uppercase; }
        .icf-af-sep { width: 1px; height: 22px; background: rgba(255,255,255,.14); }
        .icf-af-tag { font-size: .59rem; font-weight: 600; letter-spacing: .18em; color: rgba(255,255,255,.33); text-transform: uppercase; }
        .icf-af-right { display: flex; align-items: center; gap: 1rem; }
        .icf-af-right a { font-size: .68rem; color: rgba(255,255,255,.42); text-decoration: none; font-weight: 500; transition: color .14s; }
        .icf-af-right a:hover { color: rgba(255,255,255,.8); }
        .icf-af-right .bs { color: rgba(255,255,255,.18); }

        /* ── Responsive ──────────────────────────────────────────── */
        @media (max-width: 1100px) {
            .icf-auth-body { grid-template-columns: minmax(0, 1.2fr) minmax(360px, 1fr); }
        }
        @media (max-width: 860px) {
            .icf-auth-body { grid-template-columns: 1fr; }
            .icf-auth-hero { display: none; }
            .icf-auth-panel { padding: 2rem 1.25rem; min-height: calc(100vh - 130px); }
            .icf-auth-topbar-tagline { display: none; }
        }
        @media (max-width: 575.98px) {
            .icf-auth-topbar { padding: 0 1rem; height: 64px; }
            .icf-auth-topbar-brand { gap: 0.65rem !important; }
            .icf-auth-topbar-brand .icf-brand-emblem-svg { width: 60px; height: 30px; }
            .icf-auth-topbar-brand .icf-brand-divider { height: 1.6rem !important; }
            .icf-auth-topbar-brand .icf-brand-title { font-size: 0.82rem !important; }
            .icf-auth-topbar-brand .icf-brand-sub { display: none !important; }
            .icf-auth-panel { padding: 1.5rem 0.85rem; }
            .icf-auth-card { padding: 1.75rem 1.15rem; width: 100%; border-radius: 0.875rem; }
            .icf-auth-footer { height: auto; padding: 0.85rem 1rem; flex-direction: column; gap: 0.5rem; text-align: center; }
            .icf-af-left, .icf-af-right { justify-content: center; flex-wrap: wrap; gap: 0.65rem; }
            .icf-af-sep { display: none; }
        }
    </style>
</head>
<body>
<div class="icf-auth-page">

    {{-- Top Bar --}}
    <header class="icf-auth-topbar">
        <a class="icf-auth-topbar-brand" href="{{ route('landing') }}" style="display: inline-flex; align-items: center; gap: 1.15rem; text-decoration: none;">
            <span style="position: relative; display: inline-block; line-height: 1;">
                <svg width="92" height="46" viewBox="0 0 92 46" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="icf-brand-emblem-svg">
                    <text x="6" y="37" fill="#ffffff" font-family="'Times New Roman', 'Playfair Display', 'Cinzel', Georgia, serif" font-size="38" font-weight="600" letter-spacing="1">ICF</text>
                    <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e" stroke="#071f3b" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M2 41 C 22 21, 52 19, 83 22 C 52 22, 26 26, 10 41 Z" fill="#c8a96e"/>
                </svg>
            </span>
            <span class="icf-brand-divider" style="width: 1px; height: 2.35rem; background: rgba(255, 255, 255, 0.5); display: inline-block; flex-shrink: 0;"></span>
            <div style="display: flex; flex-direction: column; justify-content: center;">
                <div class="icf-brand-title" style="font-family: 'Cinzel', 'Playfair Display', 'Times New Roman', Georgia, serif; font-size: 1.05rem; font-weight: 600; letter-spacing: 0.06em; color: #ffffff; line-height: 1.15; text-transform: uppercase;">
                    ICF INVESTMENT BANK
                </div>
                <div class="icf-brand-sub" style="font-family: 'Inter', sans-serif; font-size: 0.62rem; font-weight: 500; letter-spacing: 0.24em; color: #c8a96e; text-transform: uppercase; margin-top: 0.25rem; line-height: 1;">
                    CAPITAL &nbsp;&middot;&nbsp; TRUST &nbsp;&middot;&nbsp; GROWTH
                </div>
            </div>
        </a>
        <div class="icf-auth-topbar-tagline">
            Trust <span class="sep">/</span> Growth <span class="sep">/</span> Opportunity
        </div>
    </header>

    {{-- Body Split --}}
    <div class="icf-auth-body">

        {{-- Left Hero --}}
        <div class="icf-auth-hero">
            <div class="icf-auth-hero-bg"></div>
            <div class="icf-auth-hero-overlay"></div>
            <div class="icf-auth-hero-content">
                <div class="icf-hero-rule"></div>
                <h2 class="icf-hero-headline">Bank with Confidence<br>Invest in Your Future</h2>
                <p class="icf-hero-sub">Secure access to your accounts, investments and financial services — all in one place.</p>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="icf-auth-panel">
            <div class="icf-auth-card">

                <div class="icf-clogo">
                    <span class="icf-clogo-mark">ICF</span>
                </div>
                <h1 class="icf-card-h1">Client Sign In</h1>
                <p class="icf-card-sub">Access your secure client portal.</p>

                @if ($errors->any())
                    <div class="icf-alert-err">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="icf-f-wrap">
                        <label class="icf-f-label" for="email">Email Address</label>
                        <div class="icf-f-row @error('email') err @enderror">
                            <div class="icf-f-ico">
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
                            <div class="icf-f-err">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="icf-f-wrap">
                        <label class="icf-f-label" for="password">Password</label>
                        <div class="icf-f-row @error('password') err @enderror">
                            <div class="icf-f-ico">
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
                            <button type="button" class="icf-f-eye" id="togglePw" aria-label="Toggle password visibility">
                                <svg id="eyeIco" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="icf-f-err">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="icf-row-rf">
                        <label class="icf-check-lbl" id="rememberLabel">
                            <input type="checkbox" name="remember" id="remember" value="1" checked style="position:absolute;opacity:0;pointer-events:none;">
                            <span class="icf-chk" id="chkBox">
                                <svg width="9" height="9" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            Remember this device
                        </label>
                        <a href="#" class="icf-forgot">Forgot password?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="icf-btn-signin">
                        Sign In
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>

                </form>

                {{-- Security notice --}}
                <div class="icf-sec-note">
                    <svg width="16" height="16" fill="none" stroke="#c9a84c" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:.1rem;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <p>Your security matters. We use industry-standard encryption to protect your information.</p>
                </div>

            </div>
        </div>

    </div>

    {{-- Footer --}}
    <footer class="icf-auth-footer">
        <div class="icf-af-left">
            <a class="icf-af-logo" href="{{ route('landing') }}">
                <div class="icf-af-logobox">ICF</div>
                <div class="icf-af-logotext">
                    <div class="af1">International Capital and Finance</div>
                    <div class="af2">Investment Bank</div>
                </div>
            </a>
            <div class="icf-af-sep"></div>
            <span class="icf-af-tag">Professional Service. Lasting Relationships.</span>
        </div>
        <div class="icf-af-right">
            <a href="#">Privacy</a>
            <span class="bs">|</span>
            <a href="#">Security</a>
            <span class="bs">|</span>
            <a href="#">Contact Support</a>
        </div>
    </footer>

</div>

<script>
    // ── Password visibility toggle ────────────────────────────────────
    (function () {
        const btn  = document.getElementById('togglePw');
        const inp  = document.getElementById('password');
        const ico  = document.getElementById('eyeIco');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var show = inp.type === 'text';
            inp.type = show ? 'password' : 'text';
            ico.innerHTML = show
                ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
                : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        });
    })();

    // ── Remember checkbox toggle ──────────────────────────────────────
    (function () {
        var box   = document.getElementById('chkBox');
        var input = document.getElementById('remember');
        if (!box) return;
        box.addEventListener('click', function () {
            input.checked = !input.checked;
            if (input.checked) {
                box.style.background = '#2563eb';
                box.style.border     = 'none';
                box.querySelector('svg').style.opacity = '1';
            } else {
                box.style.background = '#fff';
                box.style.border     = '2px solid #d1d9e8';
                box.querySelector('svg').style.opacity = '0';
            }
        });
    })();
</script>
</body>
</html>
