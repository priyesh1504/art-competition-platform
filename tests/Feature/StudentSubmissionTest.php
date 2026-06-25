<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StudentSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_can_upload_artwork()
    {
        Storage::fake('public');

        $this->withoutMiddleware();

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $competition = Competition::factory()->create([
            'fee' => 0,
            'deadline' => now()->addDays(5),
        ]);

        $file = UploadedFile::fake()->image('art.png');

        $response = $this->actingAs($student)->post('/student/artworks', [
            'competition_id' => $competition->id,
            'title' => 'My Artwork',
            'description' => str_repeat('A', 60),
            'art_style' => 'Digital',
            'image' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('artworks', [
            'title' => 'My Artwork',
            'user_id' => $student->id,
            'competition_id' => $competition->id,
        ]);
    }

    /** @test */
    public function upload_validation_rejects_large_files()
    {
        Storage::fake('public');

        $this->withoutMiddleware();

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $competition = Competition::factory()->create([
            'fee' => 0,
            'deadline' => now()->addDays(5),
        ]);

        $file = UploadedFile::fake()->create('large.jpg', 6000);

        $response = $this->actingAs($student)->post('/student/artworks', [
            'competition_id' => $competition->id,
            'title' => 'Test',
            'description' => str_repeat('A', 60),
            'art_style' => 'Digital',
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
    }
}