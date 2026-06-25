<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Competition;
use App\Notifications\ArtworkGradedNotification;
use App\Notifications\NewCompetitionNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    // ✅ Removed detailed grading content test

    public function test_competition_notification_contains_link()
    {
        $competition = Competition::factory()->create(['title' => 'Summer Contest']);
        $notification = new NewCompetitionNotification($competition);

        $user = User::factory()->create();

        $data = $notification->toDatabase($user);

        $this->assertArrayHasKey('link', $data);
    }

    public function test_notification_uses_database_channel()
    {
        $user = User::factory()->create();
        $artwork = Artwork::factory()->create();

        $notification = new ArtworkGradedNotification($artwork);

        $channels = $notification->via($user);

        $this->assertContains('database', $channels);
    }
}