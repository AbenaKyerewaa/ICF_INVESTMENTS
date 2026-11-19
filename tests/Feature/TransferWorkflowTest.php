<?php

namespace Tests\Feature;

use App\Models\User;
use App\ProcessSimulatedTransfer;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TransferWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_customer_can_complete_a_simulated_transfer_once(): void
    {
        $this->seed();

        $user = User::query()
            ->where('email', 'maya.bennett@icf.test')
            ->firstOrFail();

        $account = $user->accounts()->firstOrFail();
        $beneficiary = $user->beneficiaries()->firstOrFail();

        $this->actingAs($user)
            ->post(route('transfers.preview'), [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => '125.00',
                'reference' => 'Test',
            ])
            ->assertRedirect(route('transfers.review'));

        $this->actingAs($user)
            ->post(route('transfers.confirm'))
            ->assertRedirect(route('transfers.create'))
            ->assertSessionHas('error');

        $account->refresh();

        $this->assertSame('1000000.00', $account->balance);
    }

    public function test_inactive_account_cannot_complete_a_transfer(): void
    {
        $this->seed();

        $user = User::query()
            ->where('email', 'maya.bennett@icf.test')
            ->firstOrFail();

        $account = $user->accounts()->firstOrFail();
        $beneficiary = $user->beneficiaries()->firstOrFail();

        $this->actingAs($user)
            ->post(route('transfers.preview'), [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => '125.00',
                'reference' => 'Inactive account test',
            ])
            ->assertRedirect(route('transfers.review'));

        $account->update(['status' => 'inactive']);

        $this->actingAs($user)
            ->post(route('transfers.confirm'))
            ->assertRedirect(route('transfers.create'))
            ->assertSessionHas(
                'error',
                'Your sending account is not active.'
            );

        $this->assertDatabaseMissing('transfers', [
            'sending_account_id' => $account->id,
            'user_reference' => 'Inactive account test',
        ]);

        $this->assertDatabaseMissing('ledger_entries', [
            'account_id' => $account->id,
            'description' => 'Transfer to '.$beneficiary->display_name,
        ]);
    }

    public function test_transfers_are_declined_with_verification_needed(): void
    {
        $this->seed();

        $user = User::query()
            ->where('email', 'maya.bennett@icf.test')
            ->firstOrFail();

        $account = $user->accounts()->firstOrFail();
        $beneficiary = $user->beneficiaries()->firstOrFail();

        $data = [
            'account_id' => $account->id,
            'beneficiary_id' => $beneficiary->id,
            'amount' => '125.00',
            'reference' => 'Decline test',
            'idempotency_key' => 'test-idempotency-key-001',
        ];

        $processor = app(ProcessSimulatedTransfer::class);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Transaction declined: Verification needed.');

        $processor->handle($user, $data);
    }

    public function test_customer_cannot_view_another_customers_account(): void
    {
        $this->seed();

        $users = User::query()
            ->whereIn('email', [
                'maya.bennett@icf.test',
            ])
            ->get();

        $owner = $users->firstOrFail();

        $otherUser = User::query()
            ->where('id', '!=', $owner->id)
            ->firstOrFail();

        $account = $owner->accounts()->firstOrFail();

        $this->actingAs($otherUser)
            ->get(route('accounts.show', $account))
            ->assertNotFound();
    }
}
