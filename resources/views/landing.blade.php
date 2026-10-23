@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section py-5 py-lg-6">
        <div class="page-container hero-inner">
            <div class="row align-items-center g-5 py-4">
                <div class="col-lg-8 col-xl-7">
                    <span class="eyebrow eyebrow-gold mb-3 fade-up">✦ TRUSTED BANKING & INVESTMENT SOLUTIONS</span>
                    <h1 class="hero-title mt-3 mb-4 fade-up-2">
                        Bank with Confidence. <span>Invest in Your Future</span>.
                    </h1>
                    <p class="hero-copy mb-4 fade-up-3">
                       ICF Investment Bank delivers a modern approach to financial management, combining innovative banking solutions, strategic investment services, and transparent financial insights to help you manage your wealth with confidence. Track multi-asset portfolio performance, execute verified transfers and maintain an immutable ledger.                    </p>
                    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                        @auth
                            <a class="btn btn-icf-primary py-3 px-4 fs-6" href="{{ route('dashboard') }}">
                                Enter Workspace
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <a class="btn btn-icf-primary py-3 px-4 fs-6" href="{{ route('login') }}">
                                Client Login
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                            <a class="btn btn-outline-light py-3 px-4 fs-6" href="#capabilities" style="border-radius: var(--radius-sm); font-weight: 600;">
                                Explore Architecture
                            </a>
                        @endauth
                    </div>
                    <div class="d-flex align-items-center gap-3 pt-2 text-white-50 small">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Atomic double-entry ledger
                        </span>
                        <span>•</span>
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            Continuous reconciliation
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Institutional Trust Bar --}}
    <div class="trust-bar py-3 border-top border-bottom border-dark">
        <div class="page-container py-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 gap-md-4">
                <div class="trust-item">
                    <span class="trust-dot"></span>
                    <span>256-Bit Hardware Encryption</span>
                </div>
                <div class="trust-item">
                    <span class="trust-dot"></span>
                    <span>Real-Time Double-Entry Reconciliations</span>
                </div>
                <div class="trust-item">
                    <span class="trust-dot"></span>
                    <span>Strict Idempotent Transfer Engine</span>
                </div>
                <div class="trust-item">
                    <span class="trust-dot"></span>
                    <span>Immutable Cryptographic Audit Trail</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Institutional Statistics --}}
    <div class="bg-white py-5 border-bottom">
        <div class="page-container py-2">
            <div class="row g-4 text-center text-md-start">
                <div class="col-sm-6 col-lg-3">
                    <div class="stat-number">$1.4B+</div>
                    <div class="stat-label">Assets Reconciled</div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="stat-number">99.99%</div>
                    <div class="stat-label">Platform Uptime</div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="stat-number">&lt;50ms</div>
                    <div class="stat-label">Ledger Finality</div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Double-Entry Balance Parity</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Capabilities Section --}}
    <section id="capabilities" class="features-section py-5 py-lg-6">
        <div class="page-container py-3">
            <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-5">
                <div>
                    <span class="eyebrow mb-2">Institutional Capabilities</span>
                    <h2 class="h2 fw-bold mt-2 mb-0" style="color: var(--icf-navy);">Engineered for private wealth standards.</h2>
                </div>
                <p class="text-secondary mb-0 max-w-md" style="max-width: 420px;">
                    Every transaction is guarded by strict ledger consistency rules, verified beneficiaries, and automated statement generation.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <article class="feature-card feature-card--img">
                        <div class="feature-card-img">
                            <img src="/images/customers.jpg" alt="Portfolio Analytics" loading="lazy">
                            <div class="feature-card-img-badge">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 9l-5 5-4-4-3 3"/></svg>
                                Portfolio Analytics
                            </div>
                        </div>
                        <div class="feature-card-body">
                            <h3 class="h5 fw-bold mb-2">Portfolio Analytics</h3>
                            <p class="text-secondary mb-0 small lh-lg">
                                Track inflows, outflows, and net changes with interactive Chart.js visualizations across flexible 30-day, 90-day, 6-month, and 12-month periods.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="feature-card feature-card--img">
                        <div class="feature-card-img">
                            <img src="/images/transfer.jpg" alt="Verified Transfers" loading="lazy">
                            <div class="feature-card-img-badge">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                Verified Transfers
                            </div>
                        </div>
                        <div class="feature-card-body">
                            <h3 class="h5 fw-bold mb-2">Verified Transfers</h3>
                            <p class="text-secondary mb-0 small lh-lg">
                                Execute capital disbursements with idempotency guarantees, preview reviews, confirmed recipient validation, and instant PDF receipts.
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="feature-card feature-card--img">
                        <div class="feature-card-img">
                            <img src="/images/back.jpg" alt="Audit & Compliance" loading="lazy">
                            <div class="feature-card-img-badge">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Audit & Compliance
                            </div>
                        </div>
                        <div class="feature-card-body">
                            <h3 class="h5 fw-bold mb-2">Audit & Compliance</h3>
                            <p class="text-secondary mb-0 small lh-lg">
                                Every debit and credit is an immutable ledger entry. Comprehensive administrative oversight, user role boundaries, and downloadable statements.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- Security & Architecture Banner --}}
    <section class="page-container py-5">
        <div class="surface-card p-4 p-lg-5" style="background: linear-gradient(135deg, var(--icf-navy-2) 0%, var(--icf-navy) 100%); color: #fff; border-color: rgba(255,255,255,0.08);">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="eyebrow eyebrow-gold mb-3">Security &amp; Integrity</span>
                    <h2 class="h2 fw-bold text-white mt-2 mb-3">Secure Banking Solutions for a Changing World.</h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; max-width: 620px;">
ICF Investment Bank is committed to protecting client information through robust security measures, transparent financial reporting, and reliable transaction management. Our systems are designed to safeguard financial records, maintain accurate account balances, and support secure, efficient banking operations with integrity and accountability.                    </p>
                    <div class="d-flex flex-wrap gap-4 text-white-50 small">
                        <div class="d-flex align-items-center gap-2">
                            <svg width="18" height="18" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span>Session rate-limiting &amp; CSRF protection</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <svg width="18" height="18" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span>Official signed PDF statements</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    @auth
                        <a class="btn btn-icf-primary py-3 px-4 fs-6" href="{{ route('dashboard') }}">
                            Go to Dashboard →
                        </a>
                    @else
                        <a class="btn btn-icf-primary py-3 px-4 fs-6" href="{{ route('login') }}">
                            Access Client Portal →
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection
