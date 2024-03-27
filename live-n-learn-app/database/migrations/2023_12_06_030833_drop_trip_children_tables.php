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
        Schema::dropIfExists('trip_itineraries');
        Schema::dropIfExists('trip_cost_breakdown');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
