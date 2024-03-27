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
        Schema::create('inbound_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->foreignId('partner_id')->references('id')->on('partners');
            $table->string('origin_country');
            $table->string('national_language');
            $table->unsignedInteger('available_seats');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('inbound_program_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('program_id')->references('id')->on('inbound_programs');
        });

        Schema::create('inbound_program_flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->references('id')->on('inbound_programs');
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
            $table->unique(['program_id', 'flight_index', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_programs');
    }
};
