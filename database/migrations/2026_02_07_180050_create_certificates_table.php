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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        
        // Link to the artwork that earned this
        $table->foreignId('artwork_id')->constrained('artworks')->onDelete('cascade');
        
        // Link to the student
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // File path of generated certificate
        $table->string('image_path');
        
        $table->softDeletes(); // For data integrity (Soft Deletion)
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
