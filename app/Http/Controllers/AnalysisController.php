<?php

namespace App\Http\Controllers;

use App\Services\AccountAnalyticsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function __invoke(Request $request, AccountAnalyticsService $analyticsService): View
    {
        $account = $request->user()->accounts()->where('account_reference', 'ICF-482100119')->first()
            ?? $request->user()->accounts()->where('status', 'active')->first();
        $account?->sync2024Ledger();

        $range = $request->query('range', '12m');
        $from = $request->query('from');
        $to = $request->query('to');

        $analytics = $account
            ? $analyticsService->getMonthlyTrends($account, (string) $range, $from ? (string) $from : null, $to ? (string) $to : null)
            : null;

        return view('analysis', compact('account', 'analytics', 'range', 'from', 'to'));
    }
}
