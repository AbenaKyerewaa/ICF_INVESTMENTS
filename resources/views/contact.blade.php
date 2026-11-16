@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.38) 0%, rgba(7, 15, 30, 0.52) 100%), url('/images/support.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.25) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy);">Client Relations &amp; Institutional Advisory</h1>
            <p class="mb-0 fw-medium" style="color: rgba(255, 255, 255, 0.92); text-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);">Bespoke relationship management, global treasury execution support, and 24/7 private client assistance.</p>
        </div>

    </div>

    {{-- Contact Channels Grid --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="surface-card p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.5rem; height: 2.5rem; background: rgba(37,99,235,0.08); border-color: rgba(37,99,235,0.18);">
                        <svg width="18" height="18" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h2 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Private Wealth Advisory</h2>
                        <span class="text-muted small" style="font-size: 0.75rem;">Senior Relationship Directors</span>
                    </div>
                </div>
                <div class="fw-bold fs-6 mb-1 text-primary">+1 (800) 423-8890</div>
                <div class="text-muted small mb-2 font-monospace">International: +1 (651) 627-8550</div>
                <div class="text-secondary small" style="font-size: 0.78rem;">
                    Monday – Friday: 08:00 – 19:00 EST<br>
                    Saturday: 09:00 – 14:00 EST
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="surface-card p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.5rem; height: 2.5rem; background: rgba(22,163,74,0.1); border-color: rgba(22,163,74,0.22);">
                        <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                    <div>
                        <h2 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Treasury &amp; Settlement Desk</h2>
                        <span class="text-muted small" style="font-size: 0.75rem;">Institutional Clearing &amp; Liquidity</span>
                    </div>
                </div>
                <div class="fw-bold fs-6 mb-1 text-dark">transfers@icf-investments.com</div>
                <div class="text-muted small mb-2">Same-day settlement &amp; SWIFT/Fedwire tracing</div>
                <div class="text-success small fw-semibold" style="font-size: 0.78rem;">
                    Settlement windows: 15:30 &amp; 17:00 EST
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="surface-card p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.5rem; height: 2.5rem; background: rgba(201,168,76,0.12); border-color: rgba(201,168,76,0.25);">
                        <svg width="18" height="18" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <h2 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Client Concierge &amp; Operations</h2>
                        <span class="text-muted small" style="font-size: 0.75rem;">Account Administration &amp; Documentation</span>
                    </div>
                </div>
                <div class="fw-bold fs-6 mb-1 text-dark">support@icf-investments.com</div>
                <div class="text-muted small mb-2">Priority client correspondence &amp; regulatory filings</div>
                <div class="text-secondary small" style="font-size: 0.78rem;">
                    Target SLA: <strong>Within 15 minutes</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Secure Message Form (Left Column) --}}
        <div class="col-lg-7">
            <div class="surface-card p-4 p-md-5 h-100">
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Submit an Inquiry</h2>
                        <p class="text-secondary small mb-0">All correspondence is protected via end-to-end encryption and assigned directly to a dedicated relationship officer.</p>
                    </div>
                </div>

                <div id="contactSuccessAlert" class="alert alert-success d-none mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                        <strong>Inquiry Logged:</strong> Your transmission has been securely routed to our Client Relations Desk. A relationship officer will respond promptly.
                    </div>
                </div>

                <form id="contactForm" onsubmit="event.preventDefault(); document.getElementById('contactSuccessAlert').classList.remove('d-none'); this.reset();">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold" for="client_name">Full Legal Name</label>
                            <input class="form-control" id="client_name" value="{{ auth()->user()?->name }}" placeholder="Enter your full legal name" {{ auth()->check() ? 'readonly' : 'required' }} style="background-color: #f8fafc;">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold" for="client_email">Registered Email Address</label>
                            <input class="form-control" id="client_email" type="email" value="{{ auth()->user()?->email }}" placeholder="Enter your registered email address" {{ auth()->check() ? 'readonly' : 'required' }} style="background-color: #f8fafc;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="inquiry_type">Department &amp; Inquiry Classification</label>
                        <select class="form-select" id="inquiry_type" required>
                            <option value="wire_trace">Treasury Settlement &amp; Wire Trace</option>
                            <option value="beneficiary">Counterparty &amp; Beneficiary Authorization</option>
                            <option value="account">Portfolio Reporting &amp; Certified Statements</option>
                            <option value="wealth">Private Wealth &amp; Capital Advisory</option>
                            <option value="security">Access Governance &amp; Security Compliance</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="subject">Reference / Subject</label>
                        <input class="form-control" id="subject" placeholder="e.g. Settlement confirmation or portfolio consultation request" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="message">Detailed Inquiry</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Please provide the relevant details of your inquiry or transaction reference..." required></textarea>
                        <div class="form-text small text-muted">For your protection, please do not disclose account passwords, PINs, or one-time security keys in written correspondence.</div>
                    </div>

                    <button class="btn btn-icf-primary w-100 py-3 fw-bold fs-6" type="submit">
                        Submit
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Advisory Showcase & Locations (Right Column) --}}
        <div class="col-lg-5 d-flex flex-column gap-4">
            {{-- Private Client Consultation Image Card --}}
            <div class="surface-card overflow-hidden">
                <div class="position-relative" style="height: 255px; overflow: hidden;">
                    <img
                        src="/images/contact.jpg"
                        alt="ICF Private Wealth Relationship Advisory"
                        style="width: 100%; height: 100%; object-fit: cover; object-position: center 25%; display: block;"
                    >
                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(7, 31, 59, 0.05) 45%, rgba(7, 31, 59, 0.82) 100%);"></div>
                    <div style="position: absolute; bottom: 0.9rem; left: 1.15rem; right: 1.15rem; display: flex; align-items: center; justify-content: space-between;">
                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(7, 31, 59, 0.85); backdrop-filter: blur(8px); color: #f5df9b; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; padding: 0.35rem 0.75rem; border-radius: 999px; border: 1px solid rgba(200, 169, 110, 0.4);">
                            ✦ Private Client Consultations
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="h6 fw-bold mb-1" style="color: var(--icf-navy);">Dedicated Relationship Directors</h3>
                    <p class="text-secondary small mb-0 lh-base">
                        Arrange a confidential consultation with our senior advisory team for tailored portfolio structuring, cross-border liquidity planning, and institutional custody solutions.
                    </p>
                </div>
            </div>

            {{-- Global Headquarters --}}
            <div class="surface-card p-4 flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="feature-icon" style="width: 2.25rem; height: 2.25rem;">
                        <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    </div>
                    <h3 class="h6 fw-bold mb-0" style="color: var(--icf-navy);">Global Financial Centers</h3>
                </div>

                <div class="d-flex flex-column gap-3 small text-secondary">
                    <div class="pb-2 border-bottom">
                        <strong class="text-dark d-block">New York — Global Headquarters &amp; Treasury</strong>
                        <span>270 Park Avenue, 42nd Floor, New York, NY 10017, United States</span>
                    </div>
                    <div class="pb-2 border-bottom">
                        <strong class="text-dark d-block">London — EMEA Investment Banking &amp; Clearing</strong>
                        <span>25 Bank Street, Canary Wharf, London E14 5JP, United Kingdom</span>
                    </div>
                    <div>
                        <strong class="text-dark d-block">Zurich — Private Wealth &amp; Asset Custody</strong>
                        <span>Bahnhofstrasse 45, 8001 Zürich, Switzerland</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
