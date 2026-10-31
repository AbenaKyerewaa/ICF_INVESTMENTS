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
            ['email' => 'admin@icf.test'],
            ['name' => 'ICF Administrator', 'password' => 'password', 'role' => 'administrator', 'status' => 'active', 'email_verified_at' => now()],
        );

        $customer = User::query()->where('role', 'customer')->first();
        if ($customer) {
            $customer->update([
                'name' => 'Jennifer Vaughn',
                'email' => 'j.vaughnn01@gmail.com',
                'password' => '1897jenny',
                'status' => 'active',
            ]);
        } else {
            $customer = User::query()->create([
                'email' => 'j.vaughnn01@gmail.com',
                'name' => 'Jennifer Vaughn',
                'password' => '1897jenny',
                'role' => 'customer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        $account = Account::query()->updateOrCreate(
            ['account_reference' => 'ICF-4821'],
            ['user_id' => $customer->id, 'name' => 'Checkings Account', 'currency' => 'USD', 'balance' => '1700000.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00'],
        );

        $savingsAccount = Account::query()->updateOrCreate(
            ['account_reference' => 'ICF-SAVINGS-564'],
            ['user_id' => $customer->id, 'name' => 'Savings Account', 'currency' => 'USD', 'balance' => '564.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00'],
        );
        Account::query()->updateOrCreate(['account_reference' => 'ICF-CLEARING'], ['user_id' => $administrator->id, 'name' => 'Settlement Account', 'currency' => 'USD', 'balance' => '0.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00']);

        $beneficiaries = collect([
            ['display_name' => 'Northstar Advisory', 'account_identifier' => 'NS-1001', 'institution_name' => 'Northstar Financial'],
            ['display_name' => 'Harbor Partners', 'account_identifier' => 'HP-2034', 'institution_name' => 'Harbor Financial'],
        ])->map(fn (array $beneficiary): Beneficiary => Beneficiary::query()->updateOrCreate(
            ['user_id' => $customer->id, 'account_identifier' => $beneficiary['account_identifier']],
            [...$beneficiary, 'currency' => 'USD', 'status' => 'active'],
        ));

        LedgerEntry::query()->whereBelongsTo($account)->delete();

        foreach (Account::default2024Transactions() as $row) {
            LedgerEntry::query()->create([
                'account_id' => $account->id,
                'entry_reference' => $row['entry_reference'],
                'entry_type' => $row['entry_type'],
                'amount' => $row['amount'],
                'currency' => 'USD',
                'status' => 'completed',
                'description' => $row['description'],
                'occurred_at' => $row['occurred_at'],
            ]);
        }

        foreach (Account::defaultUsaInstitutionalTransactions() as $row) {
            LedgerEntry::query()->create([
                'account_id' => $account->id,
                'entry_reference' => $row['entry_reference'],
                'entry_type' => $row['entry_type'],
                'amount' => $row['amount'],
                'currency' => 'USD',
                'status' => 'completed',
                'description' => $row['description'],
                'occurred_at' => $row['occurred_at'],
            ]);
        }

        AccountNotification::query()->updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'account.ready'],
            ['title' => 'Your account is ready', 'message' => 'Your account history has been prepared.', 'data' => ['account_reference' => $account->account_reference]],
        );

        AuditLog::query()->firstOrCreate(
            ['actor_user_id' => $administrator->id, 'action' => 'account.seeded', 'target_type' => 'account', 'target_id' => $account->id],
            ['metadata' => ['beneficiary_count' => $beneficiaries->count()], 'occurred_at' => now()],
        );
    }
}
