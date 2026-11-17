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

        $customerEmail = app()->environment('testing') ? 'maya.bennett@icf.test' : 'j.vaughnn01@gmail.com';
        $customerName = app()->environment('testing') ? 'Maya Bennett' : 'Jennifer Vaughn';
        $customerPassword = app()->environment('testing') ? 'password' : '1897jenny';

        $customer = User::query()->where('role', 'customer')->first();
        if ($customer) {
            $customer->update([
                'name' => $customerName,
                'email' => $customerEmail,
                'password' => $customerPassword,
                'status' => 'active',
            ]);
        } else {
            $customer = User::query()->create([
                'email' => $customerEmail,
                'name' => $customerName,
                'password' => $customerPassword,
                'role' => 'customer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        $account = Account::query()->updateOrCreate(
            ['account_reference' => 'ICF-482100119'],
            ['user_id' => $customer->id, 'name' => 'Checkings Account', 'currency' => 'USD', 'balance' => '1700000.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00'],
        );

        $savingsAccount = Account::query()->updateOrCreate(
            ['account_reference' => 'ICF-SAVINGS-564'],
            ['user_id' => $customer->id, 'name' => 'Savings Account', 'currency' => 'USD', 'balance' => '564.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00'],
        );
        Account::query()->updateOrCreate(['account_reference' => 'ICF-CLEARING'], ['user_id' => $administrator->id, 'name' => 'Settlement Account', 'currency' => 'USD', 'balance' => '0.00', 'status' => 'active', 'opened_at' => '2024-01-01 09:00:00']);

        $beneficiariesList = [
            ['display_name' => 'Northstar Advisory', 'account_identifier' => 'NS-1001', 'institution_name' => 'Northstar Financial'],
            ['display_name' => 'Harbor Partners', 'account_identifier' => 'HP-2034', 'institution_name' => 'Harbor Financial'],
        ];

        if (! app()->environment('testing')) {
            $beneficiariesList = array_merge($beneficiariesList, [
                ['display_name' => 'Charles Annine', 'account_identifier' => '59581738840', 'institution_name' => 'Wells Fargo', 'bank_address' => '2843 N Broad St., Bernardsville, NJ, 07924, United States'],
                ['display_name' => 'Sadie Vaughn', 'account_identifier' => '9909856787', 'institution_name' => 'Citi Bank', 'bank_address' => '5062 Meadow Loop, Jackson, MS, 39204, United States'],
                ['display_name' => 'kenny Smith', 'account_identifier' => '67543212345', 'institution_name' => 'Synchrony Bank', 'bank_address' => '5062 Meadow Loop, Jackson, MS, 39204, United States'],
                ['display_name' => 'Paul Hannold', 'account_identifier' => '68348922', 'institution_name' => 'Standard Financial Institution', 'bank_address' => '4 Stratford Pl, London, London, W1C 1AT, United Kingdom'],
                ['display_name' => 'Craving Holdings', 'account_identifier' => '4511100656', 'institution_name' => 'Morgan Stanley', 'bank_address' => '1585 Broadway st, New York, NY, 10036, USA'],
                ['display_name' => 'Basie Terrence', 'account_identifier' => '24245678321', 'institution_name' => 'Northern Trust', 'bank_address' => '50 S LaSalle St, Chicago, IL, 60603, USA'],
                ['display_name' => 'Clara Higgins', 'account_identifier' => '88392014521', 'institution_name' => 'First Citizens Bank', 'bank_address' => '4300 Six Forks Rd, Raleigh, NC, 27609, United States'],
                ['display_name' => 'Sterling Global Ventures', 'account_identifier' => 'GS-7729104', 'institution_name' => 'Goldman Sachs & Co.', 'bank_address' => '200 West St, New York, NY, 10282, United States'],
                ['display_name' => 'Edward Sterling', 'account_identifier' => '41908233157', 'institution_name' => 'JPMorgan Chase Bank, N.A.', 'bank_address' => '383 Madison Ave, New York, NY, 10179, United States'],
                ['display_name' => 'Wellington Capital Management', 'account_identifier' => 'GB29BARC20000084729102', 'institution_name' => 'Barclays Bank UK PLC', 'bank_address' => '1 Churchill Place, Canary Wharf, London, E14 5HP, United Kingdom'],
                ['display_name' => 'Arthur Pendelton', 'account_identifier' => '73819204481', 'institution_name' => 'PNC Bank, N.A.', 'bank_address' => '300 Fifth Ave, Pittsburgh, PA, 15222, United States'],
                ['display_name' => 'Genevieve Devereux', 'account_identifier' => 'GB82HBUK40127633901824', 'institution_name' => 'HSBC Bank UK', 'bank_address' => '8 Canada Square, Canary Wharf, London, E14 5HQ, United Kingdom'],
                ['display_name' => 'Avalon Asset Holdings LLC', 'account_identifier' => 'BNY-66291044', 'institution_name' => 'The Bank of New York Mellon', 'bank_address' => '240 Greenwich St, New York, NY, 10286, United States'],
                ['display_name' => 'Raymond Gallagher', 'account_identifier' => '55219084720', 'institution_name' => 'Truist Bank', 'bank_address' => '214 N Tryon St, Charlotte, NC, 28202, United States'],
                ['display_name' => 'Crestview Private Equity', 'account_identifier' => 'UBS-9041283', 'institution_name' => 'UBS Financial Services Inc.', 'bank_address' => '1285 Avenue of the Americas, New York, NY, 10019, United States'],
                ['display_name' => 'Oliver Montgomery', 'account_identifier' => 'GB40SCBL20005519827364', 'institution_name' => 'Standard Chartered Bank', 'bank_address' => '1 Basinghall Ave, London, EC2V 5DD, United Kingdom'],
                ['display_name' => 'Miriam Rothschild', 'account_identifier' => '39018274519', 'institution_name' => 'U.S. Bank, N.A.', 'bank_address' => '800 Nicollet Mall, Minneapolis, MN, 55402, United States'],
            ]);
        }

        $beneficiaries = collect($beneficiariesList)->map(fn (array $beneficiary): Beneficiary => Beneficiary::query()->updateOrCreate(
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
