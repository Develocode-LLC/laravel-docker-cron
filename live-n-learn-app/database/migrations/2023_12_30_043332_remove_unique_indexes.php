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
        Schema::dropIfExists('school_trip_itineraries');
        Schema::dropIfExists('user_school_trips');
        Schema::dropIfExists('school_trips');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
