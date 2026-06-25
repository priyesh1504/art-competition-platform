<?php

namespace Tests\Unit;

use App\Models\Certificate;
use App\Models\Artwork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_certificate_belongs_to_user()
    {
        $user = User::factory()->create();
        $cert = Certificate::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $cert->user->id);
    }

    public function test_certificate_belongs_to_artwork()
    {
        $artwork = Artwork::factory()->create();
        $cert = Certificate::factory()->create(['artwork_id' => $artwork->id]);

        $this->assertEquals($artwork->title, $cert->artwork->title);
    }

    public function test_certificate_is_soft_deleted()
    {
        $cert = Certificate::factory()->create();
        $cert->delete();

        $this->assertSoftDeleted('certificates', ['id' => $cert->id]);
    }
}