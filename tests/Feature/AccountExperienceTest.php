<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AccountExperienceTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_customer_can_view_only_their_account_history(): void
    {
        $this->seed();
        $user = User::query()->where('email', 'maya.bennett@icf-investment.demo')->firstOrFail();
        $account = $user->accounts()->firstOrFail();
        $this->actingAs($user)
            ->get(route('accounts.show', $account))
            ->assertOk()
            ->assertSee('Portfolio allocation')
            ->assertSee('Investment allocation credit');
        $other = Account::factory()->create();
        $this->actingAs($user)->get(route('accounts.show', $other))->assertNotFound();
    }
}
