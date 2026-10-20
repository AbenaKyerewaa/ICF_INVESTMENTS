<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementRequest;
use App\Models\Account;
use App\Models\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function receipt(Request $request, Transfer $transfer): Response
    {
        abort_unless($transfer->sendingAccount->user_id === $request->user()->id, 404);

        return Pdf::loadView('documents.receipt', compact('transfer'))->download($transfer->reference.'.pdf');
    }

    public function statement(StatementRequest $request, Account $account): Response
    {
        abort_unless($account->user_id === $request->user()->id, 404);
        $entries = $account->ledgerEntries()->whereBetween('occurred_at', [$request->date('from')->startOfDay(), $request->date('to')->endOfDay()])->orderBy('occurred_at')->get();

        return Pdf::loadView('documents.statement', compact('account', 'entries'))->download('statement-'.$account->account_reference.'.pdf');
    }
}
