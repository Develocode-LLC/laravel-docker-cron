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
        Schema::table('school_trip_itineraries', function (Blueprint $table) {
            $table->time('time')->after('itinerary_date');
        });

        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->time('time')->after('itinerary_date');
        });

        Schema::table('master_itinerary_index', function (Blueprint $table) {
            $table->time('time')->after('itinerary_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
