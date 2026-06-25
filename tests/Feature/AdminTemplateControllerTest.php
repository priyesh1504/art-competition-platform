<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminTemplateControllerTest extends TestCase
{
    public function test_certificate_background_rejects_invalid_ratio()
    {
        Storage::fake('public');

        $this->withoutMiddleware();

        $file = UploadedFile::fake()->image('wrong-ratio.png', 1000, 1000);

        $response = $this->from('/admin/templates')
            ->post(route('admin.templates.update'), [
                'certificate_bg' => $file,
            ]);

        $response->assertSessionHasErrors('certificate_bg');
    }

    public function test_certificate_background_accepts_valid_ratio_and_size()
    {
        Storage::fake('public');

        $this->withoutMiddleware();

        $file = UploadedFile::fake()->image('valid-template.png', 1123, 794);

        $response = $this->from('/admin/templates')
            ->post(route('admin.templates.update'), [
                'certificate_bg' => $file,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        Storage::disk('public')->assertExists('templates/cert_template.png');
    }

    public function test_certificate_background_rejects_small_dimensions()
    {
        Storage::fake('public');

        $this->withoutMiddleware();

        $file = UploadedFile::fake()->image('small-template.png', 1000, 700);

        $response = $this->from('/admin/templates')
            ->post(route('admin.templates.update'), [
                'certificate_bg' => $file,
            ]);

        $response->assertSessionHasErrors('certificate_bg');
    }
}