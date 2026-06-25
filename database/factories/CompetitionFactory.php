<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => now(),
            'deadline' => now()->addDays(7),
            'status' => 'upcoming',
            'fee' => 10,
            'created_by' => User::factory(), 
        ];
    }
}
