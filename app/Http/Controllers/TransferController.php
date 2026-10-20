<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreviewTransferRequest;
use App\Models\Transfer;
use App\ProcessSimulatedTransfer;
use DomainException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    public function create(Request $request): View
    {
        return view('transfers.create', ['accounts' => $request->user()->accounts()->where('status', 'active')->get(), 'beneficiaries' => $request->user()->beneficiaries()->where('status', 'active')->get()]);
    }

    public function preview(PreviewTransferRequest $request): RedirectResponse
    {
        $data = [...$request->safe()->only(['account_id', 'beneficiary_id', 'amount', 'reference']), 'idempotency_key' => (string) Str::uuid()];
        $request->session()->put('transfer.preview', $data);

        return redirect()->route('transfers.review');
    }

    public function review(Request $request): View|RedirectResponse
    {
        $data = $request->session()->get('transfer.preview');
        if (! $data) {
            return redirect()->route('transfers.create');
        } $account = $request->user()->accounts()->findOrFail($data['account_id']);
        $beneficiary = $request->user()->beneficiaries()->findOrFail($data['beneficiary_id']);

        return view('transfers.review', compact('data', 'account', 'beneficiary'));
    }

    public function confirm(Request $request, ProcessSimulatedTransfer $processor): RedirectResponse
    {
        $data = $request->session()->get('transfer.preview');
        if (! $data) {
            return redirect()->route('transfers.create');
        } try {
            $transfer = $processor->handle($request->user(), $data);
        } catch (DomainException $exception) {
            return redirect()->route('transfers.create')->with('error', $exception->getMessage());
        } $request->session()->forget('transfer.preview');

        return redirect()->route('transfers.receipt', $transfer)->with('success', 'Simulated transfer completed.');
    }

    public function receipt(Request $request, Transfer $transfer): View
    {
        abort_unless($transfer->sendingAccount->user_id === $request->user()->id, 404);

        return view('transfers.receipt',compact('transfer'));
    }
}
