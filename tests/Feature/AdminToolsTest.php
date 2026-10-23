<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class Phase14AdminToolsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_regular_customer_cannot_access_admin_routes(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $this->actingAs($customer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();

        $this->actingAs($customer)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($customer)
            ->get(route('admin.audit-logs.index'))
            ->assertForbidden();
    }

    public function test_administrator_can_view_admin_dashboard_and_metrics(): void
    {
        $this->seed();

        $admin = User::query()
            ->where('email', 'admin@icf.test')
            ->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('System Overview')
            ->assertSee('Total Users')
            ->assertSee('Total Accounts')
            ->assertSee('Recent audit activity');
    }

    public function test_administrator_can_search_and_toggle_user_status(): void
    {
        $this->seed();

        $admin = User::query()
            ->where('email', 'admin@icf.test')
            ->firstOrFail();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['search' => 'Maya']))
            ->assertOk()
            ->assertSee('Maya Bennett')
            ->assertSee('Disable User');

        // Toggle Maya Bennett from active to disabled
        $this->actingAs($admin)
            ->post(route('admin.users.toggle-status', $customer))
            ->assertRedirect();

        $customer->refresh();
        $this->assertSame('disabled', $customer->status);

        // Verify audit log was recorded
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $admin->id,
            'action' => 'admin.user.status_toggled',
            'target_type' => 'user',
            'target_id' => $customer->id,
        ]);
    }

    public function test_administrator_cannot_disable_their_own_account(): void
    {
        $this->seed();

        $admin = User::query()
            ->where('email', 'admin@icf.test')
            ->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.users.toggle-status', $admin))
            ->assertSessionHas('error');

        $admin->refresh();
        $this->assertSame('active', $admin->status);
    }

    public function test_administrator_can_toggle_account_status(): void
    {
        $this->seed();

        $admin = User::query()
            ->where('email', 'admin@icf.test')
            ->firstOrFail();

        $account = Account::query()
            ->where('account_reference', 'ICF-4821')
            ->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.accounts.toggle-status', $account))
            ->assertRedirect();

        $account->refresh();
        $this->assertSame('inactive', $account->status);

        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $admin->id,
            'action' => 'admin.account.status_toggled',
            'target_type' => 'account',
            'target_id' => $account->id,
        ]);
    }

    public function test_administrator_can_filter_audit_logs(): void
    {
        $this->seed();

        $admin = User::query()
            ->where('email', 'admin@icf.test')
            ->firstOrFail();

        AuditLog::query()->create([
            'actor_user_id' => $admin->id,
            'action' => 'demo.custom_test_action',
            'target_type' => 'test',
            'target_id' => 1,
            'metadata' => ['key' => 'value'],
            'occurred_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.audit-logs.index', ['action' => 'demo.custom_test_action']))
            ->assertOk()
            ->assertSee('demo.custom_test_action');
    }

    public function test_failed_login_creates_audit_log_without_recording_password(): void
    {
        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'maya.bennett@icf-investment.demo',
                'password' => 'wrong-secret-password-1234',
            ])
            ->assertRedirect(route('login'));

        $log = AuditLog::query()
            ->where('action', 'auth.login.failed')
            ->latest()
            ->first();

        $this->assertNotNull($log);
        $this->assertSame('maya.bennett@icf-investment.demo', $log->metadata['attempted_email'] ?? null);
        $this->assertStringNotContainsString('wrong-secret-password-1234', json_encode($log->metadata));
    }
}
