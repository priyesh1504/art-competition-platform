<?php

namespace Tests\Unit;

use App\Models\Competition;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_competition_has_many_artworks()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $competition = Competition::factory()->create(['created_by' => $admin->id]);
        $artwork = Artwork::factory()->create(['competition_id' => $competition->id]);

        $this->assertTrue($competition->artworks->contains($artwork));
    }

    public function test_competition_has_many_payments()
    {
        $competition = Competition::factory()->create(['fee' => 50.00]);
        $payment = Payment::factory()->create(['competition_id' => $competition->id]);

        $this->assertTrue($competition->payments->contains($payment));
    }

    public function test_competition_belongs_to_creator()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $competition = Competition::factory()->create(['created_by' => $admin->id]);

        $this->assertInstanceOf(User::class, $competition->creator);
        $this->assertEquals($admin->id, $competition->creator->id);
    }
}