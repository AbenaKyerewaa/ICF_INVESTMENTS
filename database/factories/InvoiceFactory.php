<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return ['user_id' => User::factory(), 'account_id' => Account::factory(), 'invoice_number' => 'INV-DEMO-'.fake()->unique()->numerify('######'), 'total' => fake()->randomFloat(2, 100, 5000), 'currency' => 'USD', 'status' => 'draft'];
    }
}
