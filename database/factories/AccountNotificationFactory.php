<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountNotificationFactory extends Factory
{
    public function definition(): array
    {
        return ['user_id' => User::factory(), 'type' => 'demo.activity', 'title' => 'Demo account update', 'message' => 'This is fictional account activity.', 'data' => ['demo' => true]];
    }
}
