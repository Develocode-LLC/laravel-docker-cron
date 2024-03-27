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
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->foreign('trip_id')->references('id')->on('trips');
        });

        Schema::table('master_itinerary_index', function (Blueprint $table) {
            $table->foreign('master_itinerary_id')->references('id')->on('master_itineraries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
