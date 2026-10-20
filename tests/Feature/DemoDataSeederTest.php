<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Beneficiary;
use App\Models\LedgerEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DemoDataSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_the_demo_seed_data_is_fictional_and_reconciles_to_the_account_balance(): void
    {
        $this->seed();

        $customer = User::query()->where('email', 'maya.bennett@icf-investment.demo')->firstOrFail();
        $account = Account::query()->whereBelongsTo($customer)->firstOrFail();
        $credits = LedgerEntry::query()->whereBelongsTo($account)->where('entry_type', 'credit')->pluck('amount')->reduce(fn (string $total, string $amount): string => bcadd($total, $amount, 2), '0.00');
        $debits = LedgerEntry::query()->whereBelongsTo($account)->where('entry_type', 'debit')->pluck('amount')->reduce(fn (string $total, string $amount): string => bcadd($total, $amount, 2), '0.00');

        $this->assertSame('customer', $customer->role);
        $this->assertSame('1000000.00', $account->balance);
        $this->assertSame($account->balance, bcsub($credits, $debits, 2));
        $this->assertSame(25, LedgerEntry::query()->whereBelongsTo($account)->count());
        $this->assertSame(2, Beneficiary::query()->whereBelongsTo($customer)->count());
    }
}
