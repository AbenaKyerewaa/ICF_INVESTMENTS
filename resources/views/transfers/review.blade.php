@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="surface-card p-4 mx-auto" style="max-width: 680px;">
        <span class="eyebrow">Review Transfer</span>
        <h1 class="h3 fw-bold mt-2">Confirm Payment Details</h1>
        <p class="text-secondary">Please verify the payment instructions below before authorizing.</p>
        <div class="border rounded-3 p-3 bg-light my-4">
            <dl class="row mb-0">
                <dt class="col-sm-4 text-secondary">From Account</dt>
                <dd class="col-sm-8 fw-bold">{{ $account->name }} ({{ $account->account_reference }})</dd>
                <dt class="col-sm-4 text-secondary">To Beneficiary</dt>
                <dd class="col-sm-8 fw-bold">{{ $beneficiary->display_name }} ({{ $beneficiary->institution_name }})</dd>
                <dt class="col-sm-4 text-secondary">Account Identifier</dt>
                <dd class="col-sm-8 font-monospace">{{ $beneficiary->account_identifier }}</dd>
                <dt class="col-sm-4 text-secondary">Transfer Amount</dt>
                <dd class="col-sm-8 h5 fw-bold text-primary mb-0">${{ number_format($data['amount'], 2) }} {{ $account->currency }}</dd>
                @if(!empty($data['reference']))
                    <dt class="col-sm-4 text-secondary mt-2">Reference Note</dt>
                    <dd class="col-sm-8 mt-2">{{ $data['reference'] }}</dd>
                @endif
            </dl>
        </div>
        <form method="POST" action="{{ route('transfers.confirm') }}" class="d-flex gap-2">
            @csrf
            <button class="btn btn-icf-primary py-2 px-4 fw-bold" type="submit">Confirm & Authorize Transfer →</button>
            <a class="btn btn-icf-secondary py-2 px-4" href="{{ route('transfers.create') }}">Cancel</a>
        </form>
    </div>
</div>
@endsection
