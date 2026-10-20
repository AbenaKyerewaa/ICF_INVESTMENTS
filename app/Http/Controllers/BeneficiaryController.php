<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function index(Request $request): View
    {
        return view('beneficiaries.index', ['beneficiaries' => Beneficiary::query()->whereBelongsTo($request->user())->latest()->paginate(10)]);
    }

    public function store(StoreBeneficiaryRequest $request): RedirectResponse
    {
        $request->user()->beneficiaries()->create([...$request->safe()->only(['display_name', 'account_identifier', 'institution_name']), 'currency' => 'USD', 'status' => 'active']);

        return back()->with('success', 'Beneficiary added.');
    }

    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary): RedirectResponse
    {
        abort_unless($beneficiary->user_id === $request->user()->id, 404);
        $beneficiary->update($request->safe()->only(['display_name', 'account_identifier', 'institution_name']));

        return back()->with('success', 'Beneficiary updated.');
    }

    public function deactivate(Request $request, Beneficiary $beneficiary): RedirectResponse
    {
        abort_unless($beneficiary->user_id === $request->user()->id, 404);
        $beneficiary->update(['status' => 'inactive']);

        return back()->with('success', 'Beneficiary deactivated.');
    }
}
