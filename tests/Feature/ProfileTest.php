<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertStatus(200);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User Updated',
                'email' => 'updated@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $user->refresh();

        $this->assertSame('Test User Updated', $user->name);
        $this->assertSame('updated@example.com', $user->email);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Another Name',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_deactivate_their_account(): void
    {
        $user = User::factory()->create([
            'is_active' => 1
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response->assertRedirect('/');

        $this->assertEquals(0, $user->fresh()->is_active);
    }

    public function test_correct_password_must_be_provided_to_deactivate_account(): void
    {
        $user = User::factory()->create([
            'is_active' => 1
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'wrong-password'
            ]);

        // now matches your controller
        $response->assertRedirect('/profile');

        // account should remain active
        $this->assertEquals(1, $user->fresh()->is_active);
    }
}
