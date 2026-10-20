<?php

namespace Tests\Feature;

use App\Models\LedgerEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TransferWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_customer_can_complete_a_simulated_transfer_once(): void
    {
        $this->seed();
        $user = User::query()->where('email', 'maya.bennett@icf-investment.demo')->firstOrFail();
        $account = $user->accounts()->firstOrFail();
        $beneficiary = $user->beneficiaries()->firstOrFail();
        $this->actingAs($user)->post(route('transfers.preview'), ['account_id' => $account->id, 'beneficiary_id' => $beneficiary->id, 'amount' => '125.00', 'reference' => 'Test'])->assertRedirect(route('transfers.review'));
        $response = $this->actingAs($user)->post(route('transfers.confirm'));
        $response->assertRedirect();
        $account->refresh();
        $this->assertSame('999875.00', $account->balance);
        $this->assertSame(26, LedgerEntry::query()->where('account_id', $account->id)->count());
    }
}
