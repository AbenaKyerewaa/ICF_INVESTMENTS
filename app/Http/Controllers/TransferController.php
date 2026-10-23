<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreviewTransferRequest;
use App\Models\AccountNotification;
use App\Models\AuditLog;
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
            AccountNotification::query()->create([
                'user_id' => $request->user()->id,
                'type' => 'transfer.failed',
                'title' => 'Transfer Failed',
                'message' => $exception->getMessage(),
                'data' => [
                    'account_id' => $data['account_id'] ?? null,
                    'amount' => $data['amount'] ?? null,
                    'reason' => $exception->getMessage(),
                    'demo' => true,
                ],
            ]);

            AuditLog::query()->create([
                'actor_user_id' => $request->user()->id,
                'action' => 'transfer.failed',
                'target_type' => 'account',
                'target_id' => $data['account_id'] ?? null,
                'metadata' => [
                    'amount' => $data['amount'] ?? null,
                    'reason' => $exception->getMessage(),
                    'demo' => true,
                ],
                'ip_address' => $request->ip(),
                'occurred_at' => now(),
            ]);

            return redirect()->route('transfers.create')->with('error', $exception->getMessage());
        }

        $request->session()->forget('transfer.preview');

        return redirect()->route('transfers.receipt', $transfer)->with('success', 'Transfer completed successfully.');
    }

    public function receipt(Request $request, Transfer $transfer): View
    {
        abort_unless($transfer->sendingAccount->user_id === $request->user()->id, 404);

        return view('transfers.receipt', compact('transfer'));
    }
}
