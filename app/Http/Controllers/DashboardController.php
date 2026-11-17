<?php

namespace App\Http\Controllers;

use App\Services\AccountAnalyticsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, AccountAnalyticsService $analyticsService): View
    {
        $checkingsAccount = $request->user()->accounts()->where('account_reference', 'ICF-482100119')->first()
            ?? $request->user()->accounts()->where('status', 'active')->first();
        $checkingsAccount?->sync2024Ledger();

        $account = $checkingsAccount;
        $savingsAccount = $request->user()->accounts()->where('account_reference', 'ICF-SAVINGS-564')->first();

        $recentEntries = $account?->ledgerEntries()->orderByDesc('occurred_at')->limit(5)->get() ?? collect();

        $range = $request->query('range', '12m');
        $from = $request->query('from');
        $to = $request->query('to');

        $analytics = $account
            ? $analyticsService->getMonthlyTrends($account, (string) $range, $from ? (string) $from : null, $to ? (string) $to : null)
            : null;

        $unreadNotificationsCount = $request->user()->notifications()->whereNull('read_at')->count();

        return view('dashboard', compact('account', 'savingsAccount', 'recentEntries', 'analytics', 'range', 'from', 'to', 'unreadNotificationsCount'));
    }
}
