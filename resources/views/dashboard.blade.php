@extends('layouts.app')

@section('content')
    <div class="page-container">
        <span class="eyebrow">Authenticated demo area</span>
        <h1 class="h2 fw-bold mt-3" style="color: var(--icf-navy);">Welcome, {{ auth()->user()->name }}.</h1>
        <p class="text-secondary">Your account dashboard will be connected to the reconciled demo ledger in Phase 9.</p>
        <div class="surface-card p-4 mt-4"><p class="mb-1 fw-bold">Access confirmed</p><p class="mb-0 text-secondary">This route is protected by Laravel authentication and active-account middleware.</p></div>
    </div>
@endsection
