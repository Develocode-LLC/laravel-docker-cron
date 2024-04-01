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
        Schema::table('user_medical_informations', function (Blueprint $table) {
            $table->string('special_accommodations_details')->default('')->change();
            $table->string('preexisting_conditions_details')->default('')->change();
            $table->string('medicine_allergies_details')->default('')->change();
            $table->string('food_allergies_details')->default('')->change();
            $table->string('prescription_medications_details')->default('')->change();
            $table->string('otc_medications_details')->default('')->change();
            $table->string('additional_information_details')->default('')->change();
            $table->string('diet')->default('')->change();
            $table->string('diet_details')->default('')->change();
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
