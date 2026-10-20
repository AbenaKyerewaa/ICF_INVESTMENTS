<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guests_are_redirected_away_from_the_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_an_active_user_can_sign_in_and_reach_the_dashboard(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk()->assertSee($user->name);
    }

    public function test_an_inactive_user_cannot_sign_in(): void
    {
        $user = User::factory()->create(['status' => 'disabled']);

        $this->from(route('login'))
            ->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('login'))
            ->assertInvalid(['email']);

        $this->assertGuest();
    }

    public function test_an_authenticated_user_can_update_their_profile_and_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('profile.update'), ['name' => 'Maya Updated', 'email' => 'maya.updated@example.test'])
            ->assertRedirect(route('profile.edit'));

        $this->actingAs($user)
            ->put(route('profile.password.update'), ['current_password' => 'password', 'password' => 'a-secure-password', 'password_confirmation' => 'a-secure-password'])
            ->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertSame('Maya Updated', $user->name);
        $this->assertSame('maya.updated@example.test', $user->email);
        $this->assertTrue(Hash::check('a-secure-password', $user->password));
    }
}
