@extends('layouts.app')

@section('content')
<div class="page-container py-5 text-center">
    <div class="surface-card p-5 mx-auto" style="max-width: 540px;">
        <div class="feature-icon mx-auto mb-3" style="width: 3.5rem; height: 3.5rem; font-size: 1.5rem; background: #fff3e0; color: #e65100;">⚡</div>
        <span class="eyebrow" style="background: #fff3e0; color: #e65100;">429 Too Many Requests</span>
        <h1 class="h3 fw-bold mt-3 mb-2">Rate Limit Reached</h1>
        <p class="text-secondary mb-4">You have sent multiple requests in a short period. Please wait a moment before trying again to ensure platform stability.</p>
        <div class="d-flex justify-content-center gap-2">
            <a class="btn btn-icf-primary" href="{{ route('dashboard') }}">Return to Dashboard</a>
            <a class="btn btn-icf-secondary" href="{{ route('landing') }}">Home</a>
        </div>
        <p class="small text-muted mt-4 mb-0">ICF Investment Management · Protection Layer</p>
    </div>
</div>
@endsection
