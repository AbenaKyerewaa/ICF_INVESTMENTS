<?php

namespace App\Services;

use App\Models\Account;
use App\Models\LedgerEntry;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class AccountAnalyticsService
{
    /**
     * @return array{
     *     range: string,
     *     startDate: string,
     *     endDate: string,
     *     labels: array<int, string>,
     *     credits: array<int, float>,
     *     debits: array<int, float>,
     *     net: array<int, float>,
     *     totalCredits: string,
     *     totalDebits: string,
     *     netChange: string,
     *     transactionCount: int,
     *     isEmpty: bool
     * }
     */
    public function getMonthlyTrends(Account $account, string $range = '12m', ?string $from = null, ?string $to = null): array
    {
        [$startDate, $endDate] = $this->resolveDateRange($range, $from, $to);

        $entries = $account->ledgerEntries()
            ->whereBetween('occurred_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()])
            ->orderBy('occurred_at')
            ->get();

        $period = CarbonPeriod::create($startDate->copy()->startOfMonth(), '1 month', $endDate->copy()->startOfMonth());

        $labels = [];
        $credits = [];
        $debits = [];
        $net = [];

        $totalCredits = '0.00';
        $totalDebits = '0.00';

        $entriesByMonth = $entries->groupBy(fn ($entry) => $entry->occurred_at->format('Y-m'));

        foreach ($period as $month) {
            $key = $month->format('Y-m');
            $labels[] = $month->format('M Y');

            /** @var Collection<int, LedgerEntry> $monthEntries */
            $monthEntries = $entriesByMonth->get($key, collect());

            $monthCredits = '0.00';
            $monthDebits = '0.00';

            foreach ($monthEntries as $entry) {
                if ($entry->entry_type === 'credit') {
                    $monthCredits = bcadd($monthCredits, (string) $entry->amount, 2);
                    $totalCredits = bcadd($totalCredits, (string) $entry->amount, 2);
                } else {
                    $monthDebits = bcadd($monthDebits, (string) $entry->amount, 2);
                    $totalDebits = bcadd($totalDebits, (string) $entry->amount, 2);
                }
            }

            $credits[] = (float) $monthCredits;
            $debits[] = (float) $monthDebits;
            $net[] = (float) bcsub($monthCredits, $monthDebits, 2);
        }

        $netChange = bcsub($totalCredits, $totalDebits, 2);

        return [
            'range' => $range,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'labels' => $labels,
            'credits' => $credits,
            'debits' => $debits,
            'net' => $net,
            'totalCredits' => $totalCredits,
            'totalDebits' => $totalDebits,
            'netChange' => $netChange,
            'transactionCount' => $entries->count(),
            'isEmpty' => $entries->isEmpty(),
        ];
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function resolveDateRange(string $range, ?string $from, ?string $to): array
    {
        if ($from && $to) {
            $start = Carbon::parse($from);
            $end = Carbon::parse($to);
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }

            return [$start, $end];
        }

        $endDate = now();
        $startDate = match ($range) {
            '30d' => now()->subDays(30),
            '90d' => now()->subDays(90),
            '6m' => now()->subMonths(5)->startOfMonth(),
            default => now()->subMonths(11)->startOfMonth(),
        };

        return [$startDate, $endDate];
    }
}
