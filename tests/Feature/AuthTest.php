<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_register_with_role_student()
    {
        $email = 'student' . rand(1000,9999) . '@gmail.com'; // ✅ real domain

        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'student',
        ]);
    }

    public function test_admin_is_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin' . rand(1000,9999) . '@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_student_cannot_access_admin_route()
    {
        $student = User::factory()->create([
            'role' => 'student',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($student)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_account_lockout_after_5_failed_attempts()
    {
        $user = User::factory()->create([
            'email' => 'lock' . rand(1000,9999) . '@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrongpassword',
            ]);
        }

        $user->refresh();

        $this->assertTrue((bool) $user->is_locked);
        $this->assertEquals(5, $user->failed_login_attempts);
    }
}