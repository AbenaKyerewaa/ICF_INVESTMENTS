@extends('layouts.app')

@section('content')
<div style="min-height: calc(100vh - var(--topbar-h)); background: linear-gradient(180deg, rgba(7, 15, 30, 0.35) 0%, rgba(7, 15, 30, 0.5) 100%), url('/images/abt.jpg') center / cover no-repeat fixed;">
<div class="page-container">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-5 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.25) !important;">
        <div>
            <h1 class="h2 fw-bold mt-2 mb-1" style="color: var(--icf-navy); letter-spacing: -0.02em;">About ICF Investment</h1>
            <p class="mb-0 fw-medium" style="color: rgba(255, 255, 255, 0.92); text-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);">International Capital &amp; Finance Investments Bank — building wealth, securing futures.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-active px-3 py-2" style="font-size: 0.75rem; border: 1px solid rgba(22, 163, 74, 0.25);">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: #16a34a; display: inline-block;"></span>
                Chartered Financial Institution
            </span>
        </div>
    </div>

    {{-- Who We Are Flagship Section --}}
    <div class="surface-card p-4 p-lg-5 mb-4 position-relative overflow-hidden">
        <div class="position-absolute top-0 end-0 p-4 d-none d-md-block opacity-10" style="pointer-events: none;">
            <svg width="220" height="220" viewBox="0 0 24 24" fill="none" stroke="var(--icf-blue)" stroke-width="1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="row g-4 align-items-center position-relative" style="z-index: 1;">
            <div class="col-lg-7 col-xl-8">
                <span class="eyebrow mb-3" style="background: rgba(37,99,235,0.08); color: var(--icf-blue); border-color: rgba(37,99,235,0.2);">
                    ✦ Corporate Identity
                </span>
                <h2 class="h3 fw-bold mb-3" style="color: var(--icf-navy); letter-spacing: -0.01em;">Who We Are</h2>
                <p class="text-secondary lead fs-6 mb-3 lh-base">
                    International Capital and Finance Investment Bank (ICF) is a financial services institution focused on providing professional financial solutions, investment support, and client-centered service. Our aim is to help individuals, businesses, and investors make informed financial decisions through a commitment to professionalism, transparency, and responsible financial management.
                </p>
                <p class="text-secondary mb-0 lh-base">
                    We believe that strong financial relationships are built on trust, clear communication, and a long-term perspective. Our approach is centered on understanding each client's objectives and providing appropriate financial services aligned with their individual needs.
                </p>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="p-3 p-md-4 rounded-3 border" style="background: rgba(248, 250, 255, 0.9); border-color: rgba(37,99,235,0.12) !important;">
                    <div class="fw-bold small mb-3 text-uppercase tracking-wider" style="color: var(--icf-navy); font-size: 0.72rem; letter-spacing: 0.08em;">
                        Core Institutional Focus
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="feature-icon flex-shrink-0" style="width: 2.2rem; height: 2.2rem; background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.2);">
                            <svg width="14" height="14" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color: var(--icf-navy);">Informed Decision Making</div>
                            <div class="text-muted" style="font-size: 0.78rem;">Rigorous market intelligence and structured advisory solutions.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="feature-icon flex-shrink-0" style="width: 2.2rem; height: 2.2rem; background: rgba(201,168,76,0.12); border-color: rgba(201,168,76,0.25);">
                            <svg width="14" height="14" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color: var(--icf-navy);">Responsible Management</div>
                            <div class="text-muted" style="font-size: 0.78rem;">Prudent risk governance, strict compliance, and fiduciary ethics.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="feature-icon flex-shrink-0" style="width: 2.2rem; height: 2.2rem; background: rgba(34,197,94,0.1); border-color: rgba(34,197,94,0.2);">
                            <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color: var(--icf-navy);">Client-First Perspective</div>
                            <div class="text-muted" style="font-size: 0.78rem;">Personalized solutions aligned with each investor's individual goals.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mission & Vision (Balanced 2-Column Grid) --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="surface-card p-4 p-lg-4 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="feature-icon" style="width:3rem;height:3rem;background:rgba(37,99,235,0.08);border-color:rgba(37,99,235,0.18);">
                            <svg width="20" height="20" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                            </svg>
                        </div>
                        <span class="badge" style="background: rgba(37,99,235,0.08); color: var(--icf-blue); border: 1px solid rgba(37,99,235,0.16); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.35rem 0.65rem; border-radius: 999px;">
                            Purpose &amp; Commitment
                        </span>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="color: var(--icf-navy);">Our Mission</h2>
                    <p class="text-secondary mb-3 lh-base">
                        Our mission is to deliver reliable, professional, and accessible financial services while maintaining high standards of integrity, accountability, and client service. We strive to help our clients navigate their financial priorities with greater clarity and confidence.
                    </p>
                </div>
                <div class="pt-3 border-top d-flex align-items-center gap-2 text-muted" style="border-color: rgba(228, 233, 242, 0.7) !important; font-size: 0.8rem;">
                    <svg width="14" height="14" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    <span>Dedicated to client clarity, dependability &amp; high standards</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="surface-card p-4 p-lg-4 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="feature-icon" style="width:3rem;height:3rem;background:rgba(201,168,76,0.12);border-color:rgba(201,168,76,0.25);">
                            <svg width="20" height="20" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                                <path d="M2 12h20"/>
                            </svg>
                        </div>
                        <span class="badge" style="background: var(--icf-gold-pale); color: var(--icf-gold); border: 1px solid rgba(201,168,76,0.25); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.35rem 0.65rem; border-radius: 999px;">
                            Long-Term Vision
                        </span>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="color: var(--icf-navy);">Our Vision</h2>
                    <p class="text-secondary mb-3 lh-base">
                        Our vision is to build lasting relationships with clients and establish a reputation for professionalism, responsible financial practices, and service excellence within the financial services industry.
                    </p>
                </div>
                <div class="pt-3 border-top d-flex align-items-center gap-2 text-muted" style="border-color: rgba(228, 233, 242, 0.7) !important; font-size: 0.8rem;">
                    <svg width="14" height="14" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    <span>Building enduring partnerships &amp; reputable excellence</span>
                </div>
            </div>
        </div>
    </div>

    {{-- By the Numbers (Key Stats) --}}
    <div class="surface-card p-4 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <div>
                <span class="eyebrow eyebrow-gold mb-1">✦ Track Record &amp; Reach</span>
                <h2 class="h5 fw-bold mb-0 mt-1" style="color: var(--icf-navy);">By the Numbers</h2>
            </div>
            <span class="text-muted small">Global institutional metrics verified annually</span>
        </div>
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="metric-card text-center p-3 p-md-4 h-100">
                    <div class="metric-value text-primary mb-1">25+</div>
                    <div class="fw-semibold text-dark small">Years of Excellence</div>
                    <span class="text-muted" style="font-size: 0.75rem;">Established institutional heritage</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="metric-card text-center p-3 p-md-4 h-100">
                    <div class="metric-value text-success mb-1">$4.8B</div>
                    <div class="fw-semibold text-dark small">Assets Under Management</div>
                    <span class="text-muted" style="font-size: 0.75rem;">Global diversified capital</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="metric-card text-center p-3 p-md-4 h-100">
                    <div class="metric-value mb-1" style="color: var(--icf-navy);">38</div>
                    <div class="fw-semibold text-dark small">Countries Served</div>
                    <span class="text-muted" style="font-size: 0.75rem;">Cross-border treasury reach</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="metric-card text-center p-3 p-md-4 h-100">
                    <div class="metric-value text-warning mb-1" style="color: #d97706 !important;">12,000+</div>
                    <div class="fw-semibold text-dark small">Trusted Clients</div>
                    <span class="text-muted" style="font-size: 0.75rem;">Private &amp; corporate partners</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Our Core Values --}}
    <div class="surface-card p-4 p-lg-4 mb-4">
        <div class="mb-4">
            <span class="eyebrow mb-2" style="background: rgba(37,99,235,0.08); color: var(--icf-blue); border-color: rgba(37,99,235,0.2);">
                ✦ Guiding Principles
            </span>
            <h2 class="h5 fw-bold mb-1" style="color: var(--icf-navy);">Our Core Values</h2>
            <p class="text-secondary small mb-0">The ethical and professional standards that govern our culture, operations, and client interactions.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-3 border h-100 d-flex flex-column justify-content-between" style="border-color: rgba(37,99,235,.15) !important; background: rgba(37,99,235,.02); transition: all .15s ease;">
                    <div>
                        <div class="feature-icon mb-3" style="width:2.4rem;height:2.4rem;background:rgba(37,99,235,0.1);border-color:rgba(37,99,235,0.2);">
                            <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <div class="fw-bold fs-6 mb-2" style="color: var(--icf-navy);">Integrity</div>
                        <p class="text-secondary small mb-0 lh-base">We believe in honest communication, ethical conduct, and responsible decision-making.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-3 border h-100 d-flex flex-column justify-content-between" style="border-color: rgba(37,99,235,.15) !important; background: rgba(37,99,235,.02); transition: all .15s ease;">
                    <div>
                        <div class="feature-icon mb-3" style="width:2.4rem;height:2.4rem;background:rgba(37,99,235,0.1);border-color:rgba(37,99,235,0.2);">
                            <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="fw-bold fs-6 mb-2" style="color: var(--icf-navy);">Transparency</div>
                        <p class="text-secondary small mb-0 lh-base">We value clear information about our services, applicable fees, transaction requirements, and client responsibilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-3 border h-100 d-flex flex-column justify-content-between" style="border-color: rgba(37,99,235,.15) !important; background: rgba(37,99,235,.02); transition: all .15s ease;">
                    <div>
                        <div class="feature-icon mb-3" style="width:2.4rem;height:2.4rem;background:rgba(37,99,235,0.1);border-color:rgba(37,99,235,0.2);">
                            <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <div class="fw-bold fs-6 mb-2" style="color: var(--icf-navy);">Professionalism</div>
                        <p class="text-secondary small mb-0 lh-base">We are committed to providing organized, respectful, and dependable client service.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-3 border h-100 d-flex flex-column justify-content-between" style="border-color: rgba(37,99,235,.15) !important; background: rgba(37,99,235,.02); transition: all .15s ease;">
                    <div>
                        <div class="feature-icon mb-3" style="width:2.4rem;height:2.4rem;background:rgba(37,99,235,0.1);border-color:rgba(37,99,235,0.2);">
                            <svg width="15" height="15" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div class="fw-bold fs-6 mb-2" style="color: var(--icf-navy);">Partnership</div>
                        <p class="text-secondary small mb-0 lh-base">We aim to understand our clients' needs and provide service that supports informed financial decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Security & Relationship Pillars (Balanced 2-Column Row) --}}
    <div class="row g-4 mb-4">
        {{-- Our Commitment to Security --}}
        <div class="col-lg-6">
            <div class="surface-card p-4 p-lg-4 h-100 d-flex flex-column justify-content-between position-relative">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="feature-icon" style="width:3rem;height:3rem;background:rgba(22,163,74,0.1);border-color:rgba(22,163,74,0.22);">
                            <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>
                        <span class="badge" style="background: rgba(22,163,74,0.1); color: #15803d; border: 1px solid rgba(22,163,74,0.22); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.35rem 0.65rem; border-radius: 999px;">
                            Asset &amp; Data Safeguards
                        </span>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="color: var(--icf-navy);">Our Commitment to Security</h2>
                    <p class="text-secondary mb-3 lh-base">
                        Protecting client information is an important part of responsible financial service. We aim to maintain appropriate safeguards for personal information, account access, and financial records in accordance with applicable requirements.
                    </p>
                </div>
                <div class="p-3 rounded-3 mt-2 d-flex gap-3 align-items-start border" style="background: rgba(248, 250, 255, 0.95); border-color: rgba(37,99,235,0.15) !important;">
                    <div class="flex-shrink-0 mt-1">
                        <svg width="16" height="16" fill="none" stroke="var(--icf-blue)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div class="small text-secondary lh-sm mb-0">
                        <strong class="text-dark d-block mb-1">Client Security Advisory:</strong>
                        Clients should always use official communication channels, protect their login credentials, and verify payment instructions before authorizing a transaction.
                    </div>
                </div>
            </div>
        </div>

        {{-- Building Long-Term Financial Relationships --}}
        <div class="col-lg-6">
            <div class="surface-card p-4 p-lg-4 h-100 d-flex flex-column justify-content-between position-relative">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="feature-icon" style="width:3rem;height:3rem;background:rgba(201,168,76,0.12);border-color:rgba(201,168,76,0.25);">
                            <svg width="20" height="20" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <span class="badge" style="background: var(--icf-gold-pale); color: var(--icf-gold); border: 1px solid rgba(201,168,76,0.25); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 0.35rem 0.65rem; border-radius: 999px;">
                            Client Centricity
                        </span>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="color: var(--icf-navy);">Building Long-Term Financial Relationships</h2>
                    <p class="text-secondary mb-3 lh-base">
                        At International Capital and Finance Investment Bank, we recognize that every client has different financial priorities. We aim to build lasting relationships through clear communication, responsible service, and a commitment to understanding those priorities.
                    </p>
                </div>
                <div class="p-3 rounded-3 mt-2 d-flex gap-3 align-items-start border" style="background: rgba(254, 252, 246, 0.95); border-color: rgba(201,168,76,0.22) !important;">
                    <div class="flex-shrink-0 mt-1">
                        <svg width="16" height="16" fill="none" stroke="var(--icf-gold)" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div class="small text-secondary lh-sm mb-0">
                        <strong class="text-dark d-block mb-1">Our Service Commitment:</strong>
                        Whether you are exploring financial services, managing account activity, or seeking information about investment-related solutions, our goal is to provide a professional and supportive experience.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact & Action CTA --}}
    <div class="balance-card p-4 p-lg-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
        <div class="balance-glow"></div>
        <div style="position:relative;z-index:1;max-width: 42rem;">
            <span class="badge mb-2 px-3 py-1" style="background: rgba(201,168,76,0.2); color: #f5df9b; border: 1px solid rgba(201,168,76,0.3); font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700;">
                ✦ Private Wealth &amp; Treasury
            </span>
            <div class="h4 fw-bold text-white mb-2">Ready to grow your wealth with us?</div>
            <div class="text-white-50 small mb-0 lh-base">
                Contact our private wealth advisors to learn how ICF Investment can work for you. Access verified treasury rails, authorized beneficiary management, and institutional wealth guidance.
            </div>
        </div>
        <div style="position:relative;z-index:1;" class="d-flex flex-wrap gap-2 flex-shrink-0">
            <a class="btn btn-icf-secondary" href="{{ route('contact') }}" style="background: rgba(255,255,255,0.12); color: #fff; border-color: rgba(255,255,255,0.2);">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Contact Us
            </a>
            <a class="btn btn-icf-primary" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                Get Started
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
</div>
@endsection
