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
        Schema::create('trip_flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->unsignedInteger('flight_index');
            $table->enum('type', ['departure', 'return']);
            $table->string('airline');
            $table->string('airline_code');
            $table->string('airline_flight_number');
            $table->foreignId('origin_airport_id')->references('id')->on('airports');
            $table->foreignId('destination_airport_id')->references('id')->on('airports');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->timestamps();
            $table->unique(['trip_id', 'flight_index', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_flights');
    }
};
