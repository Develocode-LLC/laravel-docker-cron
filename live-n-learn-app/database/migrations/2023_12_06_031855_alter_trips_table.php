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
        // Add code_prefix and cost
        Schema::table('trips', function (Blueprint $table) {
            $table->string('prefix')->nullable()->after('id');
            $table->double('cost', 8, 2)->after('available_seats');
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
