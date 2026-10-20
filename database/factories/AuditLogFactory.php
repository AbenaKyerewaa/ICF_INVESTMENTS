<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    public function definition(): array
    {
        return ['actor_user_id' => User::factory(), 'action' => 'demo.seeded', 'target_type' => 'account', 'target_id' => 1, 'metadata' => ['demo' => true], 'occurred_at' => now()];
    }
}
