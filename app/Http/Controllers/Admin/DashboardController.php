<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AuditLog;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalUsers = User::query()->count();
        $activeUsers = User::query()->where('status', 'active')->count();
        $disabledUsers = User::query()->where('status', 'disabled')->count();

        $totalAccounts = Account::query()->count();
        $activeAccounts = Account::query()->where('status', 'active')->count();
        $totalSimulatedBalance = Account::query()
            ->where('status', 'active')
            ->where('account_reference', '!=', 'ICF-CLEARING')
            ->pluck('balance')
            ->reduce(fn (string $total, string $bal): string => bcadd($total, $bal, 2), '0.00');

        $totalTransfers = Transfer::query()->count();
        $totalTransferredVolume = Transfer::query()
            ->where('status', 'completed')
            ->pluck('amount')
            ->reduce(fn (string $total, string $amt): string => bcadd($total, $amt, 2), '0.00');

        $recentAuditLogs = AuditLog::query()
            ->with('actor')
            ->latest('occurred_at')
            ->limit(8)
            ->get();

        $recentUsers = User::query()
            ->withCount('accounts')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'disabledUsers',
            'totalAccounts',
            'activeAccounts',
            'totalSimulatedBalance',
            'totalTransfers',
            'totalTransferredVolume',
            'recentAuditLogs',
            'recentUsers'
        ));
    }
}
