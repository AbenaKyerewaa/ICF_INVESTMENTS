<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\AccountNotification;
use App\Models\AuditLog;
use App\Models\Beneficiary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function index(Request $request): View
    {
        return view('beneficiaries.index', [
            'beneficiaries' => Beneficiary::query()
                ->whereBelongsTo($request->user())
                ->latest()
                ->paginate(10),
        ]);
    }

    public function store(StoreBeneficiaryRequest $request): RedirectResponse
    {
        $beneficiary = $request->user()->beneficiaries()->create([
            ...$request->safe()->only(['display_name', 'account_identifier', 'institution_name', 'bank_address']),
            'currency' => 'USD',
            'status' => 'active',
        ]);

        AuditLog::query()->create([
            'actor_user_id' => $request->user()->id,
            'action' => 'beneficiary.created',
            'target_type' => 'beneficiary',
            'target_id' => $beneficiary->id,
            'metadata' => array_filter([
                'display_name' => $beneficiary->display_name,
                'institution_name' => $beneficiary->institution_name,
                'account_identifier' => $beneficiary->account_identifier,
                'routing_number' => $request->input('routing_number'),
                'bank_address' => $beneficiary->bank_address,
            ]),
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        AccountNotification::query()->create([
            'user_id' => $request->user()->id,
            'type' => 'beneficiary.added',
            'title' => 'Beneficiary Added',
            'message' => 'New beneficiary '.$beneficiary->display_name.' was added to your account.',
            'data' => [
                'beneficiary_id' => $beneficiary->id,
                'display_name' => $beneficiary->display_name,
            ],
        ]);

        return back()->with('success', 'Beneficiary added.');
    }

    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary): RedirectResponse
    {
        abort_unless($beneficiary->user_id === $request->user()->id, 404);

        $beneficiary->update($request->safe()->only([
            'display_name',
            'account_identifier',
            'institution_name',
            'bank_address',
        ]));

        AuditLog::query()->create([
            'actor_user_id' => $request->user()->id,
            'action' => 'beneficiary.updated',
            'target_type' => 'beneficiary',
            'target_id' => $beneficiary->id,
            'metadata' => array_filter([
                'display_name' => $beneficiary->display_name,
                'account_identifier' => $beneficiary->account_identifier,
                'institution_name' => $beneficiary->institution_name,
                'bank_address' => $beneficiary->bank_address,
                'routing_number' => $request->input('routing_number'),
            ]),
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return back()->with('success', 'Beneficiary details updated successfully.');
    }

    public function deactivate(Request $request, Beneficiary $beneficiary): RedirectResponse
    {
        abort_unless($beneficiary->user_id === $request->user()->id, 404);

        $beneficiary->update(['status' => 'inactive']);

        AuditLog::query()->create([
            'actor_user_id' => $request->user()->id,
            'action' => 'beneficiary.deactivated',
            'target_type' => 'beneficiary',
            'target_id' => $beneficiary->id,
            'metadata' => [
                'display_name' => $beneficiary->display_name,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return back()->with('success', 'Beneficiary deactivated.');
    }
}
