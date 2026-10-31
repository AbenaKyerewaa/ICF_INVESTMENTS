<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountNotificationFactory extends Factory
{
    public function definition(): array
    {
        return ['user_id' => User::factory(), 'type' => 'account.activity', 'title' => 'Account update', 'message' => 'This is an account activity update.', 'data' => []];
    }
}
