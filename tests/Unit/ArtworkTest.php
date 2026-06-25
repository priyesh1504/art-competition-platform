<?php

namespace Tests\Unit;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtworkTest extends TestCase
{
    use RefreshDatabase;

    public function test_artwork_belongs_to_user()
    {
        $user = User::factory()->create(['role' => 'student']);
        $artwork = Artwork::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $artwork->user->id);
    }

    public function test_artwork_belongs_to_competition()
    {
        $competition = Competition::factory()->create();
        $artwork = Artwork::factory()->create([
            'competition_id' => $competition->id
        ]);

        $this->assertEquals($competition->id, $artwork->competition->id);
    }

    public function test_artwork_status_defaults_to_pending()
    {
        $artwork = Artwork::factory()->create();

        $this->assertEquals('pending', $artwork->status);
    }
}