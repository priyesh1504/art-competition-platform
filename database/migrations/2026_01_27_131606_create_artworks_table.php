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
    Schema::create('artworks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Student who submitted
        $table->foreignId('competition_id')->constrained('competitions')->onDelete('cascade');
        
        $table->string('title');
        $table->string('image_path'); // Link to image file
        $table->text('description')->nullable();
        
        // Grading fields
        $table->integer('score')->nullable();
        $table->text('feedback')->nullable();
        
        $table->enum('status', ['pending', 'reviewed'])->default('pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('artworks');
    }
};
