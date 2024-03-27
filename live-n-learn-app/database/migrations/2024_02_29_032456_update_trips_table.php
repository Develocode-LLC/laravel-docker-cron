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
        Schema::table('trips', function (Blueprint $table) {
            $table->renameColumn('cost', 'total_cost');
            $table->renameColumn('available_seats', 'min_available_seats');
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->double('basic_cost', 8, 2)->after('total_cost');
            $table->double('elite_cost', 8, 2)->after('basic_cost');
            $table->unsignedInteger('max_available_seats')->after('min_available_seats');
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
