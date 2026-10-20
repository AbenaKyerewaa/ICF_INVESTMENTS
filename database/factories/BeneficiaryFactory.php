<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryFactory extends Factory
{
    public function definition(): array
    {
        return ['user_id' => User::factory(), 'display_name' => fake()->name(), 'account_identifier' => 'DEMO-'.fake()->unique()->numerify('######'), 'institution_name' => 'Demo Clearing House', 'currency' => 'USD', 'status' => 'active'];
    }
}
