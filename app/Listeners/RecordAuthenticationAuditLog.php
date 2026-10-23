<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class RecordAuthenticationAuditLog
{
    public function handleLogin(Login $event): void
    {
        AuditLog::query()->create([
            'actor_user_id' => $event->user->id,
            'action' => 'auth.login.succeeded',
            'target_type' => 'user',
            'target_id' => $event->user->id,
            'metadata' => [
                'email' => $event->user->email,
                'role' => $event->user->role,
                'demo' => true,
            ],
            'ip_address' => request()->ip(),
            'occurred_at' => now(),
        ]);
    }

    public function handleFailed(Failed $event): void
    {
        AuditLog::query()->create([
            'actor_user_id' => $event->user?->id,
            'action' => 'auth.login.failed',
            'target_type' => 'user',
            'target_id' => $event->user?->id,
            'metadata' => [
                // Strictly exclude password or credentials
                'attempted_email' => $event->credentials['email'] ?? null,
                'demo' => true,
            ],
            'ip_address' => request()->ip(),
            'occurred_at' => now(),
        ]);
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            AuditLog::query()->create([
                'actor_user_id' => $event->user->id,
                'action' => 'auth.logout',
                'target_type' => 'user',
                'target_id' => $event->user->id,
                'metadata' => [
                    'email' => $event->user->email,
                    'demo' => true,
                ],
                'ip_address' => request()->ip(),
                'occurred_at' => now(),
            ]);
        }
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLogin',
            Failed::class => 'handleFailed',
            Logout::class => 'handleLogout',
        ];
    }
}
