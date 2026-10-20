@extends('layouts.app')

@section('content')
    <div class="page-container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="eyebrow">✦ Modern financial workspace</span>
                <h1 class="hero-title mt-4 mb-4">See your financial story with more clarity.</h1>
                <p class="hero-copy mb-4">ICF Investment is a thoughtfully designed investment and banking-style dashboard prototype. Track fictional account activity, review simulated transfers, and keep every detail in view.</p>
                <div class="d-flex flex-wrap gap-3"><a class="btn btn-icf-primary" href="#experience">View the experience →</a><a class="btn btn-icf-secondary" href="#principles">How it works</a></div>
                <p class="small text-secondary mt-4 mb-0">Designed around fictional data only. Nothing here represents a real account or financial service.</p>
            </div>
            <div class="col-lg-5">
                <div class="surface-card preview-window">
                    <div class="preview-card">
                        <div class="d-flex justify-content-between align-items-start mb-5"><div><p class="small text-white-50 mb-1">Primary account</p><p class="mb-0 fw-semibold">ICF •••• 4821</p></div><span class="status-badge">● Active demo</span></div>
                        <p class="small text-white-50 mb-1">Available simulated balance</p><p class="display-6 fw-bold mb-4">$1,000,000.00</p><div class="d-flex justify-content-between small text-white-50"><span>USD</span><span>DEMO/SIMULATED</span></div>
                    </div>
                    <div class="row g-3 mt-1"><div class="col-6"><div class="metric-card"><p class="metric-label">This month</p><p class="metric-value mb-0">+$24,850</p></div></div><div class="col-6"><div class="metric-card"><p class="metric-label">Activity</p><p class="metric-value mb-0">24 records</p></div></div></div>
                </div>
            </div>
        </div>

        <section id="experience" class="pt-5 mt-4">
            <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4"><div><span class="eyebrow">Built for the next step</span><h2 class="h2 fw-bold mt-3 mb-0" style="color: var(--icf-navy);">A consistent foundation for every screen.</h2></div><p class="text-secondary mb-0">Every view will use the same clear hierarchy, accessible states, and responsive patterns.</p></div>
            <div class="row g-4">
                <div class="col-md-4"><article class="surface-card h-100 p-4"><div class="feature-icon mb-4">⌘</div><h3 class="h5 fw-bold">Focused overview</h3><p class="text-secondary mb-0">Balances, account snapshots, and recent activity will be easy to scan without hiding important context.</p></article></div>
                <div class="col-md-4"><article class="surface-card h-100 p-4"><div class="feature-icon mb-4">↗</div><h3 class="h5 fw-bold">Traceable simulation</h3><p class="text-secondary mb-0">Future transfer experiences will be reviewed, validated, receipted, and clearly labeled as simulated.</p></article></div>
                <div class="col-md-4"><article class="surface-card h-100 p-4"><div class="feature-icon mb-4">◈</div><h3 class="h5 fw-bold">Reliable details</h3><p class="text-secondary mb-0">Reusable badges, tables, alerts, and empty states will keep the experience predictable on every device.</p></article></div>
            </div>
        </section>

        <section id="principles" class="surface-card p-4 p-lg-5 mt-5"><div class="row g-4 align-items-center"><div class="col-lg-7"><span class="eyebrow">Prototype principles</span><h2 class="h2 fw-bold mt-3" style="color: var(--icf-navy);">Professional presentation. Honest boundaries.</h2><p class="text-secondary mb-0">This project is intentionally designed as a portfolio simulation. It will never request real banking credentials, send money, or present itself as a licensed financial institution.</p></div><div class="col-lg-5"><div class="p-4 rounded-4" style="background: var(--icf-sky);"><p class="fw-bold mb-2" style="color: var(--icf-navy);">Design system</p><ul class="mb-0 ps-3 text-secondary small"><li>Deep navy foundation with one clear blue action color</li><li>High-contrast status patterns beyond color alone</li><li>Responsive sidebar and compact mobile navigation</li></ul></div></div></div></section>
    </div>
@endsection
