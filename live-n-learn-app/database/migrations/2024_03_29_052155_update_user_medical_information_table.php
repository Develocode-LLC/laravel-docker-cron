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
            $table->string('preexisting_conditions_warning_sign')
                ->nullable()
                ->default('')
                ->after('preexisting_conditions_details');

            $table->renameColumn('has_medicine_allergies', 'has_allergies');
            $table->renameColumn('medicine_allergies_details', 'allergies_details');
            $table->string('allergic_reaction_details')->nullable()->default('');

            $table->renameColumn('has_food_allergies', 'has_dietary_restrictions');
            $table->renameColumn('food_allergies_details', 'dietary_restriction_details');
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
