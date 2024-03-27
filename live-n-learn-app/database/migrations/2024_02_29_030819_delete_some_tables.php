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
        Schema::dropIfExists('user_school_trip_payments');
        Schema::dropIfExists('user_school_trips');
        Schema::dropIfExists('school_trip_itineraries');
        Schema::dropIfExists('school_trip');


        Schema::table('trips', function (Blueprint $table) {
            $table->foreignId('school_id')->nullable()->references('id')->on('schools')->after('id');
            $table->foreignId('partner_id')->nullable()->references('id')->on('partners')->after('school_id');
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
