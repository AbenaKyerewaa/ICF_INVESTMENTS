<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LedgerEntryFactory extends Factory
{
    public function definition(): array
    {
        return ['account_id' => Account::factory(), 'entry_reference' => 'LED-'.Str::upper(Str::random(12)), 'entry_type' => 'credit', 'amount' => fake()->randomFloat(2, 100, 5000), 'currency' => 'USD', 'status' => 'completed', 'description' => 'Synthetic demo activity', 'occurred_at' => now()];
    }
}
