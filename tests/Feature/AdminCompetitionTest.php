<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCompetitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_competition()
    {
        $this->withoutMiddleware();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/competitions', [
            'title' => 'Summer Art Contest',
            'description' => str_repeat('A', 60),
            'rules' => 'Follow the rules',
            'start_date' => now()->addDays(2)->toDateString(),
            'deadline' => now()->addDays(10)->toDateString(),
            'fee' => 10
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('competitions', [
            'title' => 'Summer Art Contest'
        ]);
    }

    public function test_admin_can_update_competition()
    {
        $this->withoutMiddleware();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $competition = Competition::factory()->create([
            'created_by' => $admin->id
        ]);

        $response = $this->actingAs($admin)->put("/admin/competitions/{$competition->id}", [
            'title' => 'Updated Title',
            'description' => str_repeat('B', 60),
            'rules' => 'Updated rules',
            'start_date' => now()->addDays(3)->toDateString(),
            'deadline' => now()->addDays(12)->toDateString(),
            'fee' => 20
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('competitions', [
            'title' => 'Updated Title'
        ]);
    }

    public function test_student_can_view_competitions_list()
    {
        $this->withoutMiddleware();

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        Competition::factory()->create();

        $response = $this->actingAs($student)->get('/student');

        $response->assertStatus(200);
    }
}