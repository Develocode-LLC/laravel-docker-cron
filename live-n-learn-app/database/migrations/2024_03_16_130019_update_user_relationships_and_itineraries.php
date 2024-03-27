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
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->foreignId('media_file_id')->nullable()->references('id')->on('media_files');
        });

        Schema::table('master_itinerary_indices', function (Blueprint $table) {
            $table->foreignId('media_file_id')->nullable()->references('id')->on('media_files');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('parent_user_id')->nullable()->references('id')->on('users');
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
