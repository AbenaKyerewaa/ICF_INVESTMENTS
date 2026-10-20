<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request, Account $account): View
    {
        abort_unless($account->user_id === $request->user()->id, 404);
        $entries = $account->ledgerEntries()->when($request->filled('type'), fn ($q) => $q->where('entry_type', $request->string('type')))->when($request->filled('from'), fn ($q) => $q->whereDate('occurred_at', '>=', $request->date('from')))->when($request->filled('to'), fn ($q) => $q->whereDate('occurred_at', '<=', $request->date('to')))->orderByDesc('occurred_at')->orderByDesc('id')->paginate(10)->withQueryString();

        return view('accounts.show', compact('account', 'entries'));
    }
}
