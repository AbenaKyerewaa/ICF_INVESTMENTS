<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Statement — {{ $account->account_reference }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #162440; margin: 30px; font-size: 12px; line-height: 1.5; }
        .header { border-bottom: 2px solid #0c1f3d; padding-bottom: 12px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #0c1f3d; margin: 0; }
        .subtitle { font-size: 11px; color: #6c7891; margin-top: 4px; }
        .meta-box { margin-bottom: 20px; background: #f6f8fc; padding: 12px; border: 1px solid #e2e8f3; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px 10px; border-bottom: 1px solid #e2e8f3; text-align: left; }
        th { background: #0c1f3d; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; }
        .credit { color: #16a085; font-weight: bold; }
        .debit { color: #dc3545; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 10px; color: #8ea0c3; border-top: 1px solid #e2e8f3; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">ICF Investment — Official Account Statement</h1>
        <div class="subtitle">Private Wealth & Asset Management · Ledger Summary</div>
    </div>
    <div class="meta-box">
        <strong>Account Name:</strong> {{ $account->name }} &nbsp;|&nbsp;
        <strong>Reference:</strong> {{ $account->account_reference }} &nbsp;|&nbsp;
        <strong>Currency:</strong> {{ $account->currency }} &nbsp;|&nbsp;
        <strong>Closing Balance:</strong> ${{ number_format($account->balance, 2) }}
    </div>
    <table>
        <thead>
            <tr>
                <th width="15%">Date</th>
                <th width="45%">Description</th>
                <th width="15%">Type</th>
                <th width="25%" style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $entry)
                <tr>
                    <td>{{ $entry->occurred_at->format('Y-m-d') }}</td>
                    <td>{{ $entry->description }}</td>
                    <td>{{ strtoupper($entry->entry_type) }}</td>
                    <td style="text-align: right;" class="{{ $entry->entry_type === 'credit' ? 'credit' : 'debit' }}">
                        {{ $entry->entry_type === 'credit' ? '+' : '-' }}${{ number_format($entry->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #6c7891; padding: 20px;">No transaction activity recorded in this date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Generated electronically by ICF Investment Management. Page 1 of 1.
    </div>
</body>
</html>
