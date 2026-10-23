<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfer Receipt — {{ $transfer->reference }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #162440; margin: 30px; font-size: 13px; line-height: 1.6; }
        .header { border-bottom: 2px solid #0c1f3d; padding-bottom: 15px; margin-bottom: 25px; }
        .title { font-size: 20px; font-weight: bold; color: #0c1f3d; margin: 0; }
        .subtitle { font-size: 12px; color: #6c7891; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #e2e8f3; text-align: left; }
        th { width: 35%; color: #6c7891; font-weight: normal; }
        td { font-weight: bold; }
        .amount { font-size: 18px; color: #16a085; }
        .footer { margin-top: 40px; font-size: 11px; color: #8ea0c3; border-top: 1px solid #e2e8f3; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">ICF Investment — Official Transfer Receipt</h1>
        <div class="subtitle">Private Wealth & Asset Management · Electronic Confirmation</div>
    </div>
    <table>
        <tr>
            <th>Reference Number</th>
            <td>{{ $transfer->reference }}</td>
        </tr>
        <tr>
            <th>Transfer Amount</th>
            <td class="amount">${{ number_format($transfer->amount, 2) }} {{ $transfer->currency }}</td>
        </tr>
        <tr>
            <th>Recipient Beneficiary</th>
            <td>{{ $transfer->beneficiary->display_name }} ({{ $transfer->beneficiary->institution_name }})</td>
        </tr>
        <tr>
            <th>Beneficiary Identifier</th>
            <td>{{ $transfer->beneficiary->account_identifier }}</td>
        </tr>
        <tr>
            <th>Date & Timestamp</th>
            <td>{{ $transfer->completed_at?->format('F j, Y, H:i:s') ?? now()->format('F j, Y, H:i:s') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Completed / Confirmed</td>
        </tr>
    </table>
    <div class="footer">
        This document serves as an electronic verification of transaction {{ $transfer->reference }}.
    </div>
</body>
</html>
