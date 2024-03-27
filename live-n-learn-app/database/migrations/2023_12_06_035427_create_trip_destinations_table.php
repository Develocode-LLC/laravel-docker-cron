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
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['destination_location_id']);
            $table->dropColumn('destination_location_id');
        });

        Schema::create('trip_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->foreignId('trip_id')->references('id')->on('trips');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_destinations');
    }
};
