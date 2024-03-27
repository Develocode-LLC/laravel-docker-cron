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
        //
        Schema::rename('trip_cost_breakdown', 'trip_cost_breakdowns');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
