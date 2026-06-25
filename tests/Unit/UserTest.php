<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_role_student()
    {
        $user = User::factory()->create(['role' => 'student']);
        $this->assertEquals('student', $user->role);
    }

    public function test_caregiver_has_many_students_via_pivot()
    {
        $caregiver = User::factory()->create(['role' => 'caregiver']);
        $student = User::factory()->create(['role' => 'student']);
        
        $caregiver->students()->attach($student->id);

        $this->assertTrue($caregiver->students->contains($student));
    }

    public function test_student_can_have_many_caregivers()
    {
        $student = User::factory()->create(['role' => 'student']);
        $caregiver = User::factory()->create(['role' => 'caregiver']);
        
        $student->caregivers()->attach($caregiver->id);

        $this->assertTrue($student->caregivers->contains($caregiver));
    }
}