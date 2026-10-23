<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View
    {
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
                'demo' => true,
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
                'demo' => true,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return back()->with('success', "Account {$account->account_reference} is now {$newStatus}.");
    }
}
