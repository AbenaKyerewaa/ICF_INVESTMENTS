<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\LedgerEntry;
use App\Models\User;
use App\ProcessSimulatedTransfer;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

/**
 * Phase 16 — Balance Reconciliation Tests.
 *
 * Verify that the ledger stays accurate after simulated operations
 * and that displayed balances always equal opening credits minus debits.
 */
class BalanceReconciliationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_opening_balance_plus_credits_minus_debits_equals_current_balance(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = Account::query()->whereBelongsTo($customer)->firstOrFail();

        $credits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'credit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $debits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'debit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $this->assertSame(
            $account->balance,
            bcsub($credits, $debits, 2),
            'Stored balance must equal credits minus debits from the ledger.'
        );
    }

    public function test_balance_decrements_correctly_after_a_transfer(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        $balanceBefore = $account->balance;

        $processor = app(ProcessSimulatedTransfer::class);
        $processor->handle($customer, [
            'account_id' => $account->id,
            'beneficiary_id' => $beneficiary->id,
            'amount' => '250.00',
            'reference' => 'Reconciliation debit check',
            'idempotency_key' => 'recon-debit-test-001',
        ]);

        $account->refresh();

        $this->assertSame(
            bcsub($balanceBefore, '250.00', 2),
            $account->balance,
            'Balance after transfer must equal balance before minus transfer amount.'
        );

        // Ledger must still reconcile
        $credits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'credit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $debits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'debit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $this->assertSame(
            $account->balance,
            bcsub($credits, $debits, 2),
            'Ledger must reconcile after transfer.'
        );
    }

    public function test_transfer_is_rejected_when_amount_exceeds_balance(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        // Step 1 — preview succeeds (amount format is valid; balance is only checked at confirm)
        $this->actingAs($customer)
            ->post(route('transfers.preview'), [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => '9999999.00',  // exceeds the $1,000,000 demo balance
                'reference' => 'Overdraft attempt',
            ])
            ->assertRedirect(route('transfers.review'));

        // Step 2 — confirm must be rejected due to insufficient balance
        $this->actingAs($customer)
            ->post(route('transfers.confirm'))
            ->assertRedirect(route('transfers.create'))
            ->assertSessionHas('error');

        // Balance must not have changed
        $account->refresh();
        $this->assertSame('1000000.00', $account->balance);
    }

    public function test_multiple_sequential_transfers_keep_ledger_reconciled(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        $processor = app(ProcessSimulatedTransfer::class);

        foreach (['100.00', '200.00', '50.00'] as $i => $amount) {
            $processor->handle($customer, [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => $amount,
                'reference' => "Multi-step test {$i}",
                'idempotency_key' => "multi-step-recon-{$i}",
            ]);
        }

        $account->refresh();

        $credits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'credit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $debits = LedgerEntry::query()
            ->whereBelongsTo($account)
            ->where('entry_type', 'debit')
            ->pluck('amount')
            ->reduce(fn (string $carry, string $v): string => bcadd($carry, $v, 2), '0.00');

        $this->assertSame(
            $account->balance,
            bcsub($credits, $debits, 2),
            'Ledger must reconcile after multiple sequential transfers.'
        );
    }
}
