<?php

namespace Tests\Feature;

use App\Models\LedgerEntry;
use App\Models\Transfer;
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
            ->where('email', 'maya.bennett@icf-investment.demo')
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
            ->assertRedirect();

        $account->refresh();

        $this->assertSame('999875.00', $account->balance);
        $this->assertSame(
            26,
            LedgerEntry::query()
                ->where('account_id', $account->id)
                ->count()
        );
    }

    public function test_inactive_account_cannot_complete_a_transfer(): void
    {
        $this->seed();

        $user = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
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

    public function test_repeating_the_same_idempotency_key_does_not_debit_twice(): void
    {
        $this->seed();

        $user = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $user->accounts()->firstOrFail();
        $beneficiary = $user->beneficiaries()->firstOrFail();

        $data = [
            'account_id' => $account->id,
            'beneficiary_id' => $beneficiary->id,
            'amount' => '125.00',
            'reference' => 'Idempotency test',
            'idempotency_key' => 'test-idempotency-key-001',
        ];

        $processor = app(ProcessSimulatedTransfer::class);

        $firstTransfer = $processor->handle($user, $data);
        $secondTransfer = $processor->handle($user, $data);

        $account->refresh();

        $this->assertSame($firstTransfer->id, $secondTransfer->id);
        $this->assertSame('999875.00', $account->balance);

        $this->assertSame(
            1,
            Transfer::query()
                ->where('sending_account_id', $account->id)
                ->where('idempotency_key', 'test-idempotency-key-001')
                ->count()
        );
    }

    public function test_customer_cannot_view_another_customers_account(): void
    {
        $this->seed();

        $users = User::query()
            ->whereIn('email', [
                'maya.bennett@icf-investment.demo',
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
