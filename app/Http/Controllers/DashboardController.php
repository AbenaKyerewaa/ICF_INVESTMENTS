<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $account = $request->user()->accounts()->where('status', 'active')->first();
        $recentEntries = $account?->ledgerEntries()->orderByDesc('occurred_at')->limit(5)->get() ?? collect();

        return view('dashboard', compact('account', 'recentEntries'));
    }
}
