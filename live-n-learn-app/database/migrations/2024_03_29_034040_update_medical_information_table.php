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
        Schema::table('user_medical_information', function (Blueprint $table) {
            $table->string('special_accommodations_details')->nullable()->change();
            $table->string('preexisting_conditions_details')->nullable()->change();
            $table->string('medicine_allergies_details')->nullable()->change();
            $table->string('food_allergies_details')->nullable()->change();
            $table->string('prescription_medications_details')->nullable()->change();
            $table->string('otc_medications_details')->nullable()->change();
            $table->string('additional_information_details')->nullable()->change();
            $table->string('diet')->nullable()->change();
            $table->string('diet_details')->nullable()->change();
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
