<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\Artwork;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    public function definition(): array
    {
        return [
            'artwork_id' => Artwork::factory(),
            'user_id' => User::factory(),
            'image_path' => 'certificates/test.jpg',
        ];
    }
}