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
        Schema::table('inbound_program_users', function (Blueprint $table) {
            $table->renameColumn('program_id', 'inbound_program_id');
        });

        Schema::table('inbound_program_flights', function (Blueprint $table) {
            $table->renameColumn('program_id', 'inbound_program_id');
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
