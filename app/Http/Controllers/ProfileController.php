<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\AccountNotification;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->update($request->safe()->only(['name', 'email']));

        AuditLog::query()->create([
            'actor_user_id' => $user->id,
            'action' => 'profile.updated',
            'target_type' => 'user',
            'target_id' => $user->id,
            'metadata' => [
                'updated_fields' => array_keys($request->safe()->only(['name', 'email'])),
                'demo' => true,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile details updated.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->update($request->safe()->only('password'));

        AuditLog::query()->create([
            'actor_user_id' => $user->id,
            'action' => 'profile.password.updated',
            'target_type' => 'user',
            'target_id' => $user->id,
            'metadata' => [
                'status' => 'password_updated',
                'demo' => true,
            ],
            'ip_address' => $request->ip(),
            'occurred_at' => now(),
        ]);

        AccountNotification::query()->create([
            'user_id' => $user->id,
            'type' => 'security.password_updated',
            'title' => 'Password Changed',
            'message' => 'Your demo account password was successfully updated.',
            'data' => ['demo' => true],
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated.');
    }
}
