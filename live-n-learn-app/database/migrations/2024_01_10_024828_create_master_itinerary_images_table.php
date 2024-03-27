<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_itinerary_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_itinerary_id')->references('id')->on('master_itineraries');
            $table->string('file_location');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_itinerary_images');
    }
};
