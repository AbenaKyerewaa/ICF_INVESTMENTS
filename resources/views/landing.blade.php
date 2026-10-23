@extends('layouts.app')

@section('content')
    <div class="page-container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="eyebrow">✦ Modern financial workspace</span>
                <h1 class="hero-title mt-4 mb-4">See your financial story with complete clarity.</h1>
                <p class="hero-copy mb-4">ICF Investment provides a modern, intuitive wealth management workspace. Track your portfolio performance, execute secure transfers, review real-time analytics, and keep every asset in view.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-icf-primary" href="{{ route('dashboard') }}">Open Workspace →</a>
                    <a class="btn btn-icf-secondary" href="#experience">Explore Features</a>
                </div>
                <p class="small text-secondary mt-4 mb-0">Trusted institutional architecture with real-time portfolio tracking.</p>
            </div>
            <div class="col-lg-5">
                <div class="surface-card preview-window">
                    <div class="preview-card">
                        <div class="d-flex justify-content-between align-items-start mb-5">
                            <div>
                                <p class="small text-white-50 mb-1">Primary Investment Account</p>
                                <p class="mb-0 fw-semibold">ICF •••• 4821</p>
                            </div>
                            <span class="status-badge" style="background: rgba(22, 160, 133, 0.25); color: #7ef1d8;">● Active Account</span>
                        </div>
                        <p class="small text-white-50 mb-1">Available balance</p>
                        <p class="display-6 fw-bold mb-4">$1,000,000.00</p>
                        <div class="d-flex justify-content-between small text-white-50">
                            <span>USD</span>
                            <span>Verified Portfolio</span>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-6">
                            <div class="metric-card">
                                <p class="metric-label">This Month</p>
                                <p class="metric-value mb-0">+$25,000</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <p class="metric-label">Activity</p>
                                <p class="metric-value mb-0">24 records</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="experience" class="pt-5 mt-4">
            <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="eyebrow">Enterprise Capabilities</span>
                    <h2 class="h2 fw-bold mt-3 mb-0" style="color: var(--icf-navy);">A consistent foundation for wealth management.</h2>
                </div>
                <p class="text-secondary mb-0">Every view utilizes real-time double-entry ledger verification, responsive charts, and institutional security.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="surface-card h-100 p-4">
                        <div class="feature-icon mb-4">⌘</div>
                        <h3 class="h5 fw-bold">Portfolio Overview</h3>
                        <p class="text-secondary mb-0">Balances, monthly credit/debit breakdowns, and transaction history structured cleanly without clutter.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="surface-card h-100 p-4">
                        <div class="feature-icon mb-4">↗</div>
                        <h3 class="h5 fw-bold">Seamless Transfers</h3>
                        <p class="text-secondary mb-0">Instant fund transfers with verified beneficiaries, idempotent execution, and downloadable PDF receipts.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="surface-card h-100 p-4">
                        <div class="feature-icon mb-4">◈</div>
                        <h3 class="h5 fw-bold">Audit & Transparency</h3>
                        <p class="text-secondary mb-0">Full append-only audit trail and downloadable official statements for seamless accounting.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="principles" class="surface-card p-4 p-lg-5 mt-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="eyebrow">Platform Architecture</span>
                    <h2 class="h2 fw-bold mt-3" style="color: var(--icf-navy);">Professional presentation. Institutional standards.</h2>
                    <p class="text-secondary mb-0">Engineered with robust security, atomic ledger accounting, role-based access control, and complete data privacy protection.</p>
                </div>
                <div class="col-lg-5">
                    <div class="p-4 rounded-4" style="background: var(--icf-sky);">
                        <p class="fw-bold mb-2" style="color: var(--icf-navy);">Platform highlights</p>
                        <ul class="mb-0 ps-3 text-secondary small">
                            <li>Deep navy foundation with responsive dark & light contrast</li>
                            <li>Real-time Chart.js activity trends and cashflow metrics</li>
                            <li>Multi-factor audit logging and protected management consoles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
