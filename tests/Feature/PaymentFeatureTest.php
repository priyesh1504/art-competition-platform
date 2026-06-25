<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_financial_records()
    {
        $this->withoutMiddleware(); // bypass auth + role middleware

        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $payment = Payment::factory()->create([
            'amount' => 50
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/payments');

        $response->assertStatus(200);
    }

    /** @test */
    public function financial_records_are_soft_deleted()
    {
        $this->withoutMiddleware(); // bypass auth + role middleware

        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $payment = Payment::factory()->create();

        $this->actingAs($admin)
            ->delete("/admin/payments/{$payment->id}");

        $this->assertSoftDeleted('payments', [
            'id' => $payment->id
        ]);
    }
}
