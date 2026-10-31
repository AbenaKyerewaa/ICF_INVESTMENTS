<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    public function definition(): array
    {
        return ['actor_user_id' => User::factory(), 'action' => 'account.seeded', 'target_type' => 'account', 'target_id' => 1, 'metadata' => [], 'occurred_at' => now()];
    }
}
