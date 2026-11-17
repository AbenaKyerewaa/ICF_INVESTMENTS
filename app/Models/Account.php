<?php

namespace App\Models;

use Database\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

#[Fillable(['user_id', 'account_reference', 'name', 'currency', 'balance', 'status', 'opened_at'])]
class Account extends Model
{
    /** @use HasFactory<AccountFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['balance' => 'decimal:2', 'opened_at' => 'datetime'];
    }

    /**
     * @return array<int, array{entry_reference: string, entry_type: string, amount: string, description: string, occurred_at: string}>
     */
    public static function default2024Transactions(): array
    {
        return [
            ['entry_reference' => 'TRX-20240110-4821', 'entry_type' => 'credit', 'amount' => '450000.00', 'description' => 'Wire Transfer from Alexander Sterling', 'occurred_at' => '2024-02-10 09:15:22'],
            ['entry_reference' => 'TRX-20240124-4821', 'entry_type' => 'debit',  'amount' => '38500.00',  'description' => 'Transfer to Eleanor Vance', 'occurred_at' => '2024-02-12 14:42:10'],
            ['entry_reference' => 'TRX-20240208-4821', 'entry_type' => 'credit', 'amount' => '275000.00', 'description' => 'Capital Remittance from Marcus Thorne', 'occurred_at' => '2024-02-15 11:05:49'],
            ['entry_reference' => 'TRX-20240219-4821', 'entry_type' => 'debit',  'amount' => '62000.00',  'description' => 'Wire Disbursement to Julianna Mercer', 'occurred_at' => '2024-02-19 16:20:33'],
            ['entry_reference' => 'TRX-20240305-4821', 'entry_type' => 'debit',  'amount' => '29400.00',  'description' => 'Settlement Payment to Harrison Locke', 'occurred_at' => '2024-03-05 10:12:08'],
            ['entry_reference' => 'TRX-20240321-4821', 'entry_type' => 'credit', 'amount' => '185000.00', 'description' => 'Incoming Wire from Victoria Kensington', 'occurred_at' => '2024-03-21 15:30:45'],
            ['entry_reference' => 'TRX-20240411-4821', 'entry_type' => 'debit',  'amount' => '54200.00',  'description' => 'Transfer to Sebastian Croft', 'occurred_at' => '2024-04-11 13:48:19'],
            ['entry_reference' => 'TRX-20240426-4821', 'entry_type' => 'credit', 'amount' => '120000.00', 'description' => 'Incoming Transfer from Nadia Al-Mansoor', 'occurred_at' => '2024-04-26 09:55:04'],
            ['entry_reference' => 'TRX-20240509-4821', 'entry_type' => 'debit',  'amount' => '47800.00',  'description' => 'Wire Transfer to Nathaniel Brooks', 'occurred_at' => '2024-05-09 11:24:37'],
            ['entry_reference' => 'TRX-20240523-4821', 'entry_type' => 'credit', 'amount' => '140000.00', 'description' => 'Capital Distribution from Sophia Chen', 'occurred_at' => '2024-05-23 16:05:12'],
            ['entry_reference' => 'TRX-20240607-4821', 'entry_type' => 'credit', 'amount' => '210000.00', 'description' => 'Incoming Remittance from Olivia Montgomery', 'occurred_at' => '2024-06-07 10:40:51'],
            ['entry_reference' => 'TRX-20240625-4821', 'entry_type' => 'debit',  'amount' => '83500.00',  'description' => 'Disbursement to Dominic Halstead', 'occurred_at' => '2024-06-25 14:18:29'],
            ['entry_reference' => 'TRX-20240714-4821', 'entry_type' => 'debit',  'amount' => '31600.00',  'description' => 'Wire Transfer to Clara Beaumont', 'occurred_at' => '2024-07-14 12:09:44'],
            ['entry_reference' => 'TRX-20240729-4821', 'entry_type' => 'credit', 'amount' => '95000.00',  'description' => 'Incoming Wire from Henrik Lindqvist', 'occurred_at' => '2024-07-29 15:52:16'],
            ['entry_reference' => 'TRX-20240808-4821', 'entry_type' => 'credit', 'amount' => '195000.00', 'description' => 'Investment Return from Benjamin Cho', 'occurred_at' => '2024-08-08 09:33:27'],
            ['entry_reference' => 'TRX-20240822-4821', 'entry_type' => 'debit',  'amount' => '64000.00',  'description' => 'Transfer to Gabriel Morales', 'occurred_at' => '2024-08-22 17:04:11'],
            ['entry_reference' => 'TRX-20240909-4821', 'entry_type' => 'credit', 'amount' => '160000.00', 'description' => 'Incoming Wire from Isabella Rossi', 'occurred_at' => '2024-09-09 10:47:58'],
            ['entry_reference' => 'TRX-20240927-4821', 'entry_type' => 'debit',  'amount' => '42500.00',  'description' => 'Settlement Payment to Arthur Pendelton', 'occurred_at' => '2024-09-27 14:15:03'],
            ['entry_reference' => 'TRX-20241015-4821', 'entry_type' => 'credit', 'amount' => '230000.00', 'description' => "Capital Remittance from Liam O'Connor", 'occurred_at' => '2024-10-15 11:29:40'],
            ['entry_reference' => 'TRX-20241028-4821', 'entry_type' => 'debit',  'amount' => '65000.00',  'description' => 'Transfer to Evelyn Sato', 'occurred_at' => '2024-10-28 15:22:14'],
            ['entry_reference' => 'TRX-20241104-4821', 'entry_type' => 'debit',  'amount' => '58900.00',  'description' => 'Wire Transfer to Hannah Lindstrom', 'occurred_at' => '2024-11-04 13:50:22'],
            ['entry_reference' => 'TRX-20241119-4821', 'entry_type' => 'credit', 'amount' => '175000.00', 'description' => 'Incoming Transfer from Mateo Valenzuela', 'occurred_at' => '2024-11-19 16:11:09'],
            ['entry_reference' => 'TRX-20241206-4821', 'entry_type' => 'debit',  'amount' => '72600.00',  'description' => 'Disbursement to Charlotte Waverly', 'occurred_at' => '2024-12-06 10:08:35'],
            ['entry_reference' => 'TRX-20241220-4821', 'entry_type' => 'credit', 'amount' => '115000.00', 'description' => 'Year-End Settlement from Lucas Van Der Berg', 'occurred_at' => '2024-12-20 15:44:18'],
        ];
    }

    /**
     * 17 institutional transactions from various USA institutions between Feb 20, 2025 and Oct 15, 2026.
     *
     * @return array<int, array{entry_reference: string, entry_type: string, amount: string, description: string, occurred_at: string}>
     */
    public static function defaultUsaInstitutionalTransactions(): array
    {
        return [
            ['entry_reference' => 'TRX-20250224-8192', 'entry_type' => 'credit', 'amount' => '485000.00', 'description' => 'Incoming Fedwire from JPMorgan Chase Bank, N.A. / NYC Treasury Desk', 'occurred_at' => '2025-02-24 10:14:22'],
            ['entry_reference' => 'TRX-20250318-7201', 'entry_type' => 'debit',  'amount' => '32500.00',  'description' => 'Wire Remittance to Bank of America, N.A. / Private Wealth Management', 'occurred_at' => '2025-03-18 14:22:45'],
            ['entry_reference' => 'TRX-20250415-3940', 'entry_type' => 'credit', 'amount' => '175000.00', 'description' => 'Direct Capital Credit from Wells Fargo Bank, N.A. / Corporate Treasury', 'occurred_at' => '2025-04-15 09:35:10'],
            ['entry_reference' => 'TRX-20250529-6184', 'entry_type' => 'debit',  'amount' => '54200.00',  'description' => 'Client Wire Settlement to Citibank, N.A. / Institutional Global Markets', 'occurred_at' => '2025-05-29 16:48:33'],
            ['entry_reference' => 'TRX-20250708-9412', 'entry_type' => 'credit', 'amount' => '220000.00', 'description' => 'Custody Portfolio Inflow from Goldman Sachs Bank USA / Asset Management', 'occurred_at' => '2025-07-08 11:20:15'],
            ['entry_reference' => 'TRX-20250819-5023', 'entry_type' => 'debit',  'amount' => '41800.00',  'description' => 'Interbank Settlement to Morgan Stanley Private Bank, N.A.', 'occurred_at' => '2025-08-19 13:05:40'],
            ['entry_reference' => 'TRX-20250926-1738', 'entry_type' => 'credit', 'amount' => '310000.00', 'description' => 'Securities Clearance Deposit from BNY Mellon / Global Custody Services', 'occurred_at' => '2025-09-26 15:42:08'],
            ['entry_reference' => 'TRX-20251114-8849', 'entry_type' => 'debit',  'amount' => '68900.00',  'description' => 'Commercial Escrow Disbursement to U.S. Bank, N.A. / Commercial Lending', 'occurred_at' => '2025-11-14 10:18:52'],
            ['entry_reference' => 'TRX-20251210-4391', 'entry_type' => 'credit', 'amount' => '190000.00', 'description' => 'Year-End Institutional Credit from PNC Bank, N.A. / Treasury Management', 'occurred_at' => '2025-12-10 16:30:19'],
            ['entry_reference' => 'TRX-20260122-3852', 'entry_type' => 'debit',  'amount' => '28400.00',  'description' => 'Clearing Transfer to Truist Bank / Wealth Advisory Operations', 'occurred_at' => '2026-01-22 11:45:30'],
            ['entry_reference' => 'TRX-20260227-6921', 'entry_type' => 'credit', 'amount' => '165000.00', 'description' => 'Asset Liquidity Inflow from State Street Bank and Trust Company', 'occurred_at' => '2026-02-27 14:12:05'],
            ['entry_reference' => 'TRX-20260409-2175', 'entry_type' => 'debit',  'amount' => '47600.00',  'description' => 'Wire Remittance to Northern Trust Company / Global Family Office', 'occurred_at' => '2026-04-09 09:50:41'],
            ['entry_reference' => 'TRX-20260518-7743', 'entry_type' => 'credit', 'amount' => '145000.00', 'description' => 'Institutional Liquidity Transfer from Capital One, N.A. / Commercial Treasury', 'occurred_at' => '2026-05-18 15:25:38'],
            ['entry_reference' => 'TRX-20260623-4519', 'entry_type' => 'debit',  'amount' => '61300.00',  'description' => 'Advisory Fee Settlement to Charles Schwab Bank, SSB', 'occurred_at' => '2026-06-23 12:10:22'],
            ['entry_reference' => 'TRX-20260731-9034', 'entry_type' => 'credit', 'amount' => '215000.00', 'description' => 'Treasury Management Inbound Wire from Fifth Third Bank, N.A.', 'occurred_at' => '2026-07-31 16:08:50'],
            ['entry_reference' => 'TRX-20260828-5681', 'entry_type' => 'debit',  'amount' => '39200.00',  'description' => 'Client Wire Disbursement to M&T Bank / Institutional Services', 'occurred_at' => '2026-08-28 10:35:14'],
            ['entry_reference' => 'TRX-20261008-8316', 'entry_type' => 'credit', 'amount' => '180000.00', 'description' => 'Syndicated Loan Distribution from Citizens Bank, N.A. / Commercial Banking', 'occurred_at' => '2026-10-08 14:40:27'],
        ];
    }

    public function sync2024Ledger(): void
    {
        if ($this->account_reference !== 'ICF-482100119') {
            return;
        }

        // 1. Ensure the linked Savings account exists with $564 balance
        self::query()->updateOrCreate(
            ['account_reference' => 'ICF-SAVINGS-564'],
            [
                'user_id' => $this->user_id,
                'name' => 'Savings Account',
                'currency' => $this->currency,
                'balance' => '564.00',
                'status' => 'active',
                'opened_at' => '2024-01-01 09:00:00',
            ]
        );

        // 2. Ensure Checkings name is set
        if ($this->name !== 'Checkings Account') {
            $this->update(['name' => 'Checkings Account']);
        }

        // 3. Ensure the base 2024 seed transactions exist once
        $has2024Seed = $this->ledgerEntries()
            ->where('entry_reference', 'TRX-20241220-4821')
            ->exists();

        if (! $has2024Seed) {
            DB::transaction(function (): void {
                $this->ledgerEntries()->where('entry_reference', 'like', 'LED-%')->delete();

                foreach (self::default2024Transactions() as $row) {
                    LedgerEntry::query()->updateOrCreate(
                        ['account_id' => $this->id, 'entry_reference' => $row['entry_reference']],
                        [
                            'transfer_id' => null,
                            'entry_type' => $row['entry_type'],
                            'amount' => $row['amount'],
                            'currency' => $this->currency,
                            'status' => 'completed',
                            'description' => $row['description'],
                            'occurred_at' => $row['occurred_at'],
                        ],
                    );
                }

                $credits = $this->ledgerEntries()
                    ->where('entry_type', 'credit')
                    ->pluck('amount')
                    ->reduce(fn (string $sum, string $amt): string => bcadd($sum, $amt, 2), '0.00');

                $debits = $this->ledgerEntries()
                    ->where('entry_type', 'debit')
                    ->pluck('amount')
                    ->reduce(fn (string $sum, string $amt): string => bcadd($sum, $amt, 2), '0.00');

                $this->update([
                    'balance' => bcsub($credits, $debits, 2),
                    'opened_at' => '2024-01-01 09:00:00',
                ]);
                $this->refresh();
            });
        }

        // 4. Ensure the 17 USA institutional transactions (Feb 2025 - Oct 2026) are placed
        $hasUsaSeed = $this->ledgerEntries()
            ->where('entry_reference', 'TRX-20261008-8316')
            ->exists();

        if (! $hasUsaSeed) {
            DB::transaction(function (): void {
                foreach (self::defaultUsaInstitutionalTransactions() as $row) {
                    LedgerEntry::query()->updateOrCreate(
                        ['account_id' => $this->id, 'entry_reference' => $row['entry_reference']],
                        [
                            'transfer_id' => null,
                            'entry_type' => $row['entry_type'],
                            'amount' => $row['amount'],
                            'currency' => $this->currency,
                            'status' => 'completed',
                            'description' => $row['description'],
                            'occurred_at' => $row['occurred_at'],
                        ],
                    );
                }

                $credits = $this->ledgerEntries()
                    ->where('entry_type', 'credit')
                    ->pluck('amount')
                    ->reduce(fn (string $sum, string $amt): string => bcadd($sum, $amt, 2), '0.00');

                $debits = $this->ledgerEntries()
                    ->where('entry_type', 'debit')
                    ->pluck('amount')
                    ->reduce(fn (string $sum, string $amt): string => bcadd($sum, $amt, 2), '0.00');

                $this->update([
                    'balance' => bcsub($credits, $debits, 2),
                ]);
                $this->refresh();
            });
        }

        // 5. Rename any remaining generic Institutional Treasury Credit / Deposit entries to 6 USA institutions
        $genericCredits = LedgerEntry::query()
            ->where('description', 'like', '%Institutional Treasury Credit%')
            ->orderBy('id')
            ->get();

        if ($genericCredits->isNotEmpty()) {
            $usaInstitutions = [
                'Direct Wire Deposit from Capital One, N.A. (Commercial Treasury)',
                'Fedwire Deposit from Citizens Bank, N.A. (Commercial Settlement Desk)',
                'Institutional Transfer from Fifth Third Bank, N.A. (Treasury Management)',
                'Incoming Wire from Huntington National Bank (Liquidity Services)',
                'Direct Liquidity Credit from KeyBank, N.A. (Institutional Advisory)',
                'Wire Settlement from Regions Bank (Corporate Treasury Solutions)',
            ];

            foreach ($genericCredits as $idx => $entry) {
                $entry->update([
                    'description' => $usaInstitutions[$idx % count($usaInstitutions)],
                ]);
            }
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgerEntries(): HasMany
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'sending_account_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
