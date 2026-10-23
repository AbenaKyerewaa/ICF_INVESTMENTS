<?php

namespace Tests\Feature;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

/**
 * Phase 16 — Beneficiary Management Tests.
 *
 * Covers add, update, deactivate flows and ownership enforcement.
 */
class BeneficiaryManagementTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_customer_can_view_their_beneficiary_list(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $this->actingAs($customer)
            ->get(route('beneficiaries.index'))
            ->assertOk();
    }

    public function test_customer_can_add_a_new_beneficiary(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $countBefore = $customer->beneficiaries()->count();

        $this->actingAs($customer)
            ->post(route('beneficiaries.store'), [
                'display_name' => 'Demo Payee Ltd',
                'account_identifier' => 'DEMO-ACCT-9900',
                'institution_name' => 'Fictional Bank PLC',
            ])
            ->assertRedirect();

        $this->assertSame($countBefore + 1, $customer->beneficiaries()->count());

        $this->assertDatabaseHas('beneficiaries', [
            'user_id' => $customer->id,
            'display_name' => 'Demo Payee Ltd',
            'status' => 'active',
        ]);

        // An audit log entry must be created
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $customer->id,
            'action' => 'beneficiary.created',
            'target_type' => 'beneficiary',
        ]);
    }

    public function test_customer_can_update_their_own_beneficiary(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        $this->actingAs($customer)
            ->patch(route('beneficiaries.update', $beneficiary), [
                'display_name' => 'Updated Display Name',
                'account_identifier' => $beneficiary->account_identifier,
                'institution_name' => $beneficiary->institution_name,
            ])
            ->assertRedirect();

        $beneficiary->refresh();
        $this->assertSame('Updated Display Name', $beneficiary->display_name);
    }

    public function test_customer_can_deactivate_their_own_beneficiary(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        $this->actingAs($customer)
            ->post(route('beneficiaries.deactivate', $beneficiary))
            ->assertRedirect();

        $beneficiary->refresh();
        $this->assertSame('inactive', $beneficiary->status);

        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $customer->id,
            'action' => 'beneficiary.deactivated',
            'target_type' => 'beneficiary',
            'target_id' => $beneficiary->id,
        ]);
    }

    public function test_adding_beneficiary_with_invalid_data_is_rejected(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $this->actingAs($customer)
            ->post(route('beneficiaries.store'), [
                'display_name' => '',   // required
                'account_identifier' => '',   // required
                // institution_name is nullable — no error expected for it
            ])
            ->assertInvalid(['display_name', 'account_identifier']);
    }

    public function test_beneficiary_history_preserved_after_deactivation(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        // Use the beneficiary in a transfer first
        $account = $customer->accounts()->firstOrFail();

        $this->actingAs($customer)
            ->post(route('transfers.preview'), [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => '10.00',
                'reference' => 'Pre-deactivation transfer',
            ])
            ->assertRedirect(route('transfers.review'));

        $this->actingAs($customer)
            ->post(route('transfers.confirm'))
            ->assertRedirect();

        // Now deactivate
        $this->actingAs($customer)
            ->post(route('beneficiaries.deactivate', $beneficiary))
            ->assertRedirect();

        $beneficiary->refresh();

        // Transfer record must remain
        $this->assertDatabaseHas('transfers', [
            'sending_account_id' => $account->id,
            'beneficiary_id' => $beneficiary->id,
        ]);

        $this->assertSame('inactive', $beneficiary->status);
    }
}
