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
        Schema::create('user_medical_informations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users');

            $table->boolean('has_special_accommodations');
            $table->string('special_accommodations_details');

            $table->boolean('has_preexisting_conditions');
            $table->string('preexisting_conditions_details');

            $table->boolean('has_medicine_allergies');
            $table->string('medicine_allergies_details');

            $table->boolean('has_food_allergies');
            $table->string('food_allergies_details');

            $table->boolean('has_prescription_medications');
            $table->string('prescription_medications_details');

            $table->boolean('has_otc_medications');
            $table->string('otc_medications_details');

            $table->boolean('has_additional_information');
            $table->string('additional_information_details');

            $table->string('diet');
            $table->string('diet_details');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_medical_informations');
    }
};
