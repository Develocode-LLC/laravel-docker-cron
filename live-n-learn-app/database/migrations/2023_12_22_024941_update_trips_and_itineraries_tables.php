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
        // Create Schools
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });

        // Create School Trip pivot table
        Schema::create('school_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->references('id')->on('schools');
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->unique('school_id', 'trip_id');
        });

        // Create School Trip pivot table
        Schema::create('user_school_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('school_trip_id')->references('id')->on('school_trips');
            $table->unique('user_id', 'school_trip_id');
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
            $table->unique('school_trip_id', 'itinerary_index');
        });

        // Create Trip itinerary
        Schema::create('trip_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->unsignedInteger('itinerary_index');
            $table->date('itinerary_date');
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();
            $table->unique('trip_id', 'itinerary_index');
        });

        // Create Master Itineraries
        Schema::create('master_itineraries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->timestamps();
        });

        // Create Master Itineraries Index
        Schema::create('master_itinerary_index', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_itinerary_id')->references('id')->on('master_itineraries');
            $table->unsignedInteger('itinerary_index');
            $table->date('itinerary_date');
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();
            $table->unique('master_itinerary_id', 'itinerary_index');
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
