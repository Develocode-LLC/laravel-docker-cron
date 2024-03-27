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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('file_location');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('trip_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->foreignId('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
        Schema::dropIfExists('trip_forms');
    }
};
