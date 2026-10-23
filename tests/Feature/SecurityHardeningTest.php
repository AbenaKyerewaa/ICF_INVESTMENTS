<?php

namespace Tests\Feature;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class Phase15SecurityHardeningTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_cannot_access_other_users_account_statement_or_receipt(): void
    {
        $this->seed();

        $maya = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $attacker = User::factory()->create();

        $mayaAccount = $maya->accounts()->firstOrFail();

        // Attacker attempts to download Maya's statement -> 404
        $this->actingAs($attacker)
            ->get(route('documents.statement', [
                'account' => $mayaAccount,
                'from' => now()->subMonth()->toDateString(),
                'to' => now()->toDateString(),
            ]))
            ->assertNotFound();

        // Create a transfer for Maya
        $mayaBeneficiary = $maya->beneficiaries()->firstOrFail();
        $transfer = Transfer::query()->create([
            'sending_account_id' => $mayaAccount->id,
            'beneficiary_id' => $mayaBeneficiary->id,
            'reference' => 'TRF-SEC-TEST1',
            'idempotency_key' => 'idemp-sec-1',
            'amount' => '50.00',
            'currency' => 'USD',
            'status' => 'completed',
        ]);

        // Attacker attempts to view Maya's transfer receipt -> 404
        $this->actingAs($attacker)
            ->get(route('transfers.receipt', $transfer))
            ->assertNotFound();

        $this->actingAs($attacker)
            ->get(route('documents.receipt', $transfer))
            ->assertNotFound();
    }

    public function test_user_cannot_modify_other_users_beneficiary(): void
    {
        $this->seed();

        $maya = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $attacker = User::factory()->create();
        $beneficiary = $maya->beneficiaries()->firstOrFail();

        $this->actingAs($attacker)
            ->patch(route('beneficiaries.update', $beneficiary), [
                'display_name' => 'Hacked Beneficiary',
                'account_identifier' => 'HACKED-1',
                'institution_name' => 'Evil Bank',
            ])
            ->assertNotFound();

        $this->actingAs($attacker)
            ->post(route('beneficiaries.deactivate', $beneficiary))
            ->assertNotFound();

        $beneficiary->refresh();
        $this->assertNotSame('Hacked Beneficiary', $beneficiary->display_name);
        $this->assertSame('active', $beneficiary->status);
    }

    public function test_user_cannot_escalate_role_via_profile_update(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $this->actingAs($customer)
            ->patch(route('profile.update'), [
                'name' => 'Maya Bennett',
                'email' => 'maya.bennett@icf-investment.demo',
                'role' => 'administrator',
            ])
            ->assertRedirect(route('profile.edit'));

        $customer->refresh();
        $this->assertSame('customer', $customer->role);
    }

    public function test_password_updates_are_rate_limited(): void
    {
        $user = User::factory()->create();

        // 6 attempts allowed per minute on password update
        for ($i = 0; $i < 6; $i++) {
            $this->actingAs($user)
                ->put(route('profile.password.update'), [
                    'current_password' => 'password',
                    'password' => 'new-password-1234',
                    'password_confirmation' => 'new-password-1234',
                ]);
        }

        // 7th attempt should hit rate limiter (429)
        $this->actingAs($user)
            ->put(route('profile.password.update'), [
                'current_password' => 'password',
                'password' => 'new-password-1234',
                'password_confirmation' => 'new-password-1234',
            ])
            ->assertStatus(429);
    }
}
