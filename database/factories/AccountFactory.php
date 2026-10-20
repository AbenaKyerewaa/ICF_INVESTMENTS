<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    public function definition(): array
    {
        return ['user_id' => User::factory(), 'account_reference' => 'ICF-'.fake()->unique()->numerify('######'), 'name' => 'Primary Demo Account', 'currency' => 'USD', 'balance' => '0.00', 'status' => 'active', 'opened_at' => now()];
    }
}
