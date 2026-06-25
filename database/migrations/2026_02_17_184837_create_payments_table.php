<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('competition_id')->constrained('competitions');
        $table->string('stripe_id')->nullable();
        $table->decimal('amount', 8, 2);
        $table->string('currency')->default('INR');
        $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
        $table->string('receipt_path')->nullable();
        
        // Multi-authorization/Integrity: Soft delete
        $table->softDeletes(); 
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
