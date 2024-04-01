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
        Schema::create('trip_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->foreignId('form_id')->references('id')->on('forms');
            $table->timestamps();
        });

        Schema::rename('form_signatures', 'trip_form_signatures');

        Schema::table('trip_form_signatures', function (Blueprint $table) {
            $table->foreignId('form_id')->nullable()->after('trip_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_forms');
    }
};
