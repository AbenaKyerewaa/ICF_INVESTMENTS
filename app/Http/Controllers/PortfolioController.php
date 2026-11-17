<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function __invoke(Request $request): View
    {
        $account = $request->user()->accounts()->where('account_reference', 'ICF-482100119')->first()
            ?? $request->user()->accounts()->where('status', 'active')->first();
        $account?->sync2024Ledger();

        return view('portfolio', compact('account'));
    }
}
