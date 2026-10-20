<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\AuditLog;
use App\Models\Beneficiary;
use App\Models\LedgerEntry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $administrator = User::query()->updateOrCreate(
            ['email' => 'admin@icf-investment.demo'],
            ['name' => 'ICF Demo Administrator', 'password' => 'password', 'role' => 'administrator', 'status' => 'active', 'email_verified_at' => now()],
        );

        $customer = User::query()->updateOrCreate(
            ['email' => 'maya.bennett@icf-investment.demo'],
            ['name' => 'Maya Bennett', 'password' => 'password', 'role' => 'customer', 'status' => 'active', 'email_verified_at' => now()],
        );

        $account = Account::query()->updateOrCreate(
            ['account_reference' => 'ICF-DEMO-4821'],
            ['user_id' => $customer->id, 'name' => 'Primary Demo Account', 'currency' => 'USD', 'balance' => '1000000.00', 'status' => 'active', 'opened_at' => now()->subYear()],
        );

        $beneficiaries = collect([
            ['display_name' => 'Northstar Demo Services', 'account_identifier' => 'DEMO-NS-1001', 'institution_name' => 'Demo Clearing House'],
            ['display_name' => 'Harbor Demo Partners', 'account_identifier' => 'DEMO-HP-2034', 'institution_name' => 'Demo Clearing House'],
        ])->map(fn (array $beneficiary): Beneficiary => Beneficiary::query()->updateOrCreate(
            ['user_id' => $customer->id, 'account_identifier' => $beneficiary['account_identifier']],
            [...$beneficiary, 'currency' => 'USD', 'status' => 'active'],
        ));

        LedgerEntry::query()->whereBelongsTo($account)->delete();

        $periodStart = now()->startOfMonth()->subMonths(12);
        LedgerEntry::query()->create(['account_id' => $account->id, 'entry_reference' => 'LED-OPEN-4821', 'entry_type' => 'credit', 'amount' => '1000000.00', 'currency' => 'USD', 'status' => 'completed', 'description' => 'Opening DEMO/SIMULATED balance', 'occurred_at' => $periodStart]);

        foreach (range(1, 12) as $month) {
            $occurredAt = $periodStart->copy()->addMonths($month);
            $suffix = $occurredAt->format('Ym');

            LedgerEntry::query()->create(['account_id' => $account->id, 'entry_reference' => "LED-CR-$suffix-4821", 'entry_type' => 'credit', 'amount' => '25000.00', 'currency' => 'USD', 'status' => 'completed', 'description' => 'Synthetic DEMO/SIMULATED investment credit', 'occurred_at' => $occurredAt]);
            LedgerEntry::query()->create(['account_id' => $account->id, 'entry_reference' => "LED-DR-$suffix-4821", 'entry_type' => 'debit', 'amount' => '25000.00', 'currency' => 'USD', 'status' => 'completed', 'description' => 'Synthetic DEMO/SIMULATED account activity', 'occurred_at' => $occurredAt->copy()->addDays(14)]);
        }

        AccountNotification::query()->updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'demo.account.ready'],
            ['title' => 'Your demo account is ready', 'message' => 'Your fictional account history has been prepared.', 'data' => ['account_reference' => $account->account_reference, 'demo' => true]],
        );

        AuditLog::query()->firstOrCreate(
            ['actor_user_id' => $administrator->id, 'action' => 'demo.account.seeded', 'target_type' => 'account', 'target_id' => $account->id],
            ['metadata' => ['beneficiary_count' => $beneficiaries->count(), 'demo' => true], 'occurred_at' => now()],
        );
    }
}
