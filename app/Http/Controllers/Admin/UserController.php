<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\AuditLog;
use App\Models\LedgerEntry;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Account::query()->where('account_reference', 'ICF-4821')->first()?->sync2024Ledger();

        $search = $request->query('search');
        $role = $request->query('role');
        $status = $request->query('status');

        $users = User::query()
            ->with('accounts')
            ->when($search, function ($query, $search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, fn ($query) => $query->where('role', $role))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role', 'status'));
    }

    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Security rule: You cannot disable your own administrator account.');
        }

        $newStatus = $user->status === 'active' ? 'disabled' : 'active';
        $user->update(['status' => $newStatus]);

        AuditLog::query()->create([
            'actor_user_id' => $request->user()->id,
            'action' => 'admin.user.status_toggled',
            'target_type' => 'user',
            'target_id' => $user->id,
            'metadata' => [
                'target_email' => $user->email,
                'new_status' => $newStatus,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return back()->with('success', "User {$user->name} is now {$newStatus}.");
    }

    public function toggleAccountStatus(Request $request, Account $account): RedirectResponse
    {
        $newStatus = $account->status === 'active' ? 'inactive' : 'active';
        $account->update(['status' => $newStatus]);

        AuditLog::query()->create([
            'actor_user_id' => $request->user()->id,
            'action' => 'admin.account.status_toggled',
            'target_type' => 'account',
            'target_id' => $account->id,
            'metadata' => [
                'account_reference' => $account->account_reference,
                'new_status' => $newStatus,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return back()->with('success', "Account {$account->account_reference} is now {$newStatus}.");
    }

    public function deposit(Request $request, Account $account): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:100000000'],
            'description' => ['nullable', 'string', 'max:160'],
        ]);

        $amount = number_format((float) $validated['amount'], 2, '.', '');
        $defaultUsaInstitutions = [
            'Direct Wire Deposit from Capital One, N.A. (Commercial Treasury)',
            'Fedwire Deposit from Citizens Bank, N.A. (Commercial Settlement Desk)',
            'Institutional Transfer from Fifth Third Bank, N.A. (Treasury Management)',
            'Incoming Wire from Huntington National Bank (Liquidity Services)',
            'Direct Liquidity Credit from KeyBank, N.A. (Institutional Advisory)',
            'Wire Settlement from Regions Bank (Corporate Treasury Solutions)',
        ];
        $description = ! empty($validated['description'])
            ? trim($validated['description'])
            : $defaultUsaInstitutions[array_rand($defaultUsaInstitutions)];

        DB::transaction(function () use ($request, $account, $amount, $description): void {
            $lockedAccount = Account::query()
                ->whereKey($account->id)
                ->lockForUpdate()
                ->firstOrFail();

            $newBalance = bcadd((string) $lockedAccount->balance, $amount, 2);
            $lockedAccount->update(['balance' => $newBalance]);

            $reference = 'DEP-'.Str::upper(Str::random(10));

            LedgerEntry::query()->create([
                'account_id' => $lockedAccount->id,
                'transfer_id' => null,
                'entry_reference' => $reference,
                'entry_type' => 'credit',
                'amount' => $amount,
                'currency' => $lockedAccount->currency,
                'status' => 'completed',
                'description' => $description,
                'occurred_at' => now(),
            ]);

            AccountNotification::query()->create([
                'user_id' => $lockedAccount->user_id,
                'type' => 'account.credited',
                'title' => 'Account Credited',
                'message' => 'Your account ('.$lockedAccount->account_reference.') has been credited with $'.number_format((float) $amount, 2).'.',
                'data' => [
                    'account_id' => $lockedAccount->id,
                    'account_reference' => $lockedAccount->account_reference,
                    'amount' => $amount,
                    'reference' => $reference,
                ],
            ]);

            AuditLog::query()->create([
                'actor_user_id' => $request->user()->id,
                'action' => 'admin.account.credited',
                'target_type' => 'account',
                'target_id' => $lockedAccount->id,
                'metadata' => [
                    'account_reference' => $lockedAccount->account_reference,
                    'amount' => $amount,
                    'new_balance' => $newBalance,
                    'reference' => $reference,
                    'description' => $description,
                ],
                'ip_address' => $request->ip(),
                'occurred_at' => now(),
            ]);
        });

        return back()->with('success', 'Successfully credited $'.number_format((float) $amount, 2)." to account {$account->account_reference}.");
    }
}
