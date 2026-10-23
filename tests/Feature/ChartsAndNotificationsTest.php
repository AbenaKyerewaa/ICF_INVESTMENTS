<?php

namespace Tests\Feature;

use App\Models\AccountNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class Phase13ChartsAndNotificationsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_dashboard_renders_chart_analytics_matching_database_records(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $response = $this->actingAs($customer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Activity trends')
            ->assertSee('Credit vs Debit Timeline')
            ->assertSee('Monthly Cashflow Breakdown')
            ->assertSee('window.accountChartData', false);

        /** @var array<string, mixed> $analytics */
        $analytics = $response->viewData('analytics');

        $this->assertNotNull($analytics);
        $this->assertSame(24, $analytics['transactionCount']);
        $this->assertFalse($analytics['isEmpty']);
        $this->assertNotEmpty($analytics['labels']);
        $this->assertNotEmpty($analytics['credits']);
        $this->assertNotEmpty($analytics['debits']);
    }

    public function test_dashboard_supports_date_range_filtering(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $response = $this->actingAs($customer)
            ->get(route('dashboard', ['range' => '30d']))
            ->assertOk();

        $analytics = $response->viewData('analytics');
        $this->assertNotNull($analytics);
        $this->assertSame('30d', $analytics['range']);
    }

    public function test_user_can_view_and_manage_notifications(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $notification = AccountNotification::query()->create([
            'user_id' => $customer->id,
            'type' => 'transfer.completed',
            'title' => 'Simulated Transfer Processed',
            'message' => 'Simulated transfer of $500.00 completed.',
            'data' => ['demo' => true],
        ]);

        $this->actingAs($customer)
            ->get(route('notifications.index'))
            ->assertOk()
            ->assertSee('Simulated Transfer Processed')
            ->assertSee('Simulated transfer of $500.00 completed.');

        // Mark single as read
        $this->actingAs($customer)
            ->patch(route('notifications.read', $notification))
            ->assertRedirect();

        $notification->refresh();
        $this->assertNotNull($notification->read_at);

        // Mark all as read
        AccountNotification::query()->create([
            'user_id' => $customer->id,
            'type' => 'demo.alert',
            'title' => 'Another Notification',
            'message' => 'Test message',
            'read_at' => null,
        ]);

        $this->actingAs($customer)
            ->post(route('notifications.read-all'))
            ->assertRedirect();

        $this->assertSame(0, $customer->notifications()->whereNull('read_at')->count());
    }

    public function test_user_cannot_access_or_modify_another_users_notifications(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $otherUser = User::factory()->create();

        $otherNotification = AccountNotification::query()->create([
            'user_id' => $otherUser->id,
            'type' => 'security.alert',
            'title' => 'Private Alert',
            'message' => 'Secret alert for other user',
        ]);

        // Attempting to read another user's notification should abort with 404
        $this->actingAs($customer)
            ->patch(route('notifications.read', $otherNotification))
            ->assertNotFound();

        // Attempting to delete another user's notification should abort with 404
        $this->actingAs($customer)
            ->delete(route('notifications.destroy', $otherNotification))
            ->assertNotFound();

        $otherNotification->refresh();
        $this->assertNull($otherNotification->read_at);
    }
}
