@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="surface-card p-4 mx-auto" style="max-width: 680px;">
        <span class="eyebrow mb-3">Capital Transfer</span>
        <h1 class="h3 fw-bold mt-2">Transfer Funds</h1>
        <p class="text-secondary">Select your source account and beneficiary to initiate a secure transfer.</p>
        <form method="POST" action="{{ route('transfers.preview') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">From Account</label>
                <select class="form-select" name="account_id" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->account_reference }}) · ${{ number_format($account->balance, 2) }} {{ $account->currency }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">To Beneficiary</label>
                <select class="form-select" name="beneficiary_id" required>
                    @foreach($beneficiaries as $beneficiary)
                        <option value="{{ $beneficiary->id }}">{{ $beneficiary->display_name }} ({{ $beneficiary->institution_name }} · {{ $beneficiary->account_identifier }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Amount (USD)</label>
                <input class="form-control" name="amount" type="number" step="0.01" min="0.01" placeholder="0.00" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold">Reference Note (Optional)</label>
                <input class="form-control" name="reference" placeholder="e.g. Portfolio Allocation, Advisory Fee">
            </div>
            <button class="btn btn-icf-primary w-100 py-2 fw-bold" type="submit">Continue to Review →</button>
        </form>
    </div>
</div>
@endsection
