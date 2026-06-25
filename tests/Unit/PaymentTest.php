<?php

namespace Tests\Unit;

use App\Models\Payment;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_belongs_to_user()
    {
        $user = User::factory()->create();
        $payment = Payment::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $payment->user->id);
    }

    public function test_payment_belongs_to_competition()
    {
        $comp = Competition::factory()->create();
        $payment = Payment::factory()->create(['competition_id' => $comp->id]);

        $this->assertEquals($comp->id, $payment->competition_id);
    }

    public function test_payment_amount_is_stored_as_decimal()
    {
        $payment = Payment::factory()->create(['amount' => 50.50]);

        $this->assertIsFloat($payment->amount);
        $this->assertEquals(50.50, $payment->amount);
    }

    public function test_payment_is_soft_deleted()
    {
        $payment = Payment::factory()->create();
        $payment->delete();

        $this->assertSoftDeleted('payments', ['id' => $payment->id]);
    }
}