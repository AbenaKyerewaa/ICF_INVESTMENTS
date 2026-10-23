@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="surface-card p-4 mx-auto" style="max-width: 680px;">
        <span class="eyebrow">Transaction Successful</span>
        <h1 class="h3 fw-bold mt-2">Transfer Completed</h1>
        <p class="text-secondary">Your transfer has been processed and posted to the account ledger.</p>
        <div class="border rounded-3 p-3 bg-light my-4">
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">Reference</dt>
                <dd class="col-sm-8 font-monospace fw-bold text-dark">{{ $transfer->reference }}</dd>
                <dt class="col-sm-4 text-secondary">Amount</dt>
                <dd class="col-sm-8 h5 fw-bold text-success mb-0">${{ number_format($transfer->amount, 2) }} {{ $transfer->currency }}</dd>
                <dt class="col-sm-4 text-secondary mt-2">Recipient</dt>
                <dd class="col-sm-8 fw-semibold mt-2">{{ $transfer->beneficiary->display_name }}</dd>
                <dt class="col-sm-4 text-secondary">Date & Time</dt>
                <dd class="col-sm-8">{{ $transfer->completed_at?->format('M j, Y H:i:s') ?? now()->format('M j, Y H:i:s') }}</dd>
                @if($transfer->user_reference)
                    <dt class="col-sm-4 text-secondary">Note</dt>
                    <dd class="col-sm-8">{{ $transfer->user_reference }}</dd>
                @endif
            </dl>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-icf-primary py-2 px-4" href="{{ route('documents.receipt', $transfer) }}">Download PDF Receipt</a>
            <a class="btn btn-icf-secondary py-2 px-4" href="{{ route('dashboard') }}">Return to Dashboard</a>
        </div>
    </div>
</div>
@endsection
