<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Competition;

class ArtworkFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'competition_id' => Competition::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image_path' => 'artworks/test.jpg',
            'score' => null,
            'feedback' => null,
            'status' => 'pending'
        ];
    }
}
