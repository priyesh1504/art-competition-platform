<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Competition;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'competition_id' => Competition::factory(),
            'stripe_id' => null,
            'amount' => 50,
            'currency' => 'INR',
            'status' => 'completed',
            'receipt_path' => null,
            'artwork_id' => null,
        ];
    }
}
