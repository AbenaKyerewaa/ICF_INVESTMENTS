<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransferFactory extends Factory
{
    public function definition(): array
    {
        return ['sending_account_id' => Account::factory(), 'beneficiary_id' => Beneficiary::factory(), 'reference' => 'TRF-'.Str::upper(Str::random(12)), 'idempotency_key' => (string) Str::uuid(), 'amount' => fake()->randomFloat(2, 100, 5000), 'currency' => 'USD', 'status' => 'completed', 'completed_at' => now(), 'metadata' => ['demo' => true]];
    }
}
