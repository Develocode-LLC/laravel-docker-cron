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
            $table->dropForeign(['trip_id']);
            $table->dropUnique('itinerary_index');
            $table->index(['trip_id', 'itinerary_index']);
        });

        Schema::table('master_itinerary_index', function (Blueprint $table) {
            $table->dropForeign(['master_itinerary_id']);
            $table->dropUnique('itinerary_index');
            $table->index(['master_itinerary_id', 'itinerary_index']);
        });

        // Create School Trip pivot table
        Schema::create('school_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->references('id')->on('schools');
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->unique(['school_id', 'trip_id']);
        });

        // Create School Trip pivot table
        Schema::create('user_school_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('school_trip_id')->references('id')->on('school_trips');
            $table->unique(['user_id', 'school_trip_id']);
        });

        // Create School Trip itinerary
        Schema::create('school_trip_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_trip_id')->references('id')->on('school_trips');
            $table->unsignedInteger('itinerary_index');
            $table->date('itinerary_date');
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();
            $table->index(['school_trip_id', 'itinerary_index']);
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
