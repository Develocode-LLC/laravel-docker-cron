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
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('first_name');
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('t_shirt_size')->nullable();
            $table->string('gender')->nullable();
            $table->string('gender_identity')->nullable();
            $table->string('passport_file_location')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiration_date')->nullable();
            $table->mediumText('health_medical_information')->nullable();
            $table->mediumText('dietry_preferences')->nullable();
            $table->tinyInteger('follows_diet')->default(0);
            $table->tinyInteger('eats_seafood')->default(0);
            $table->tinyInteger('rides_bike')->default(0);
        });

        Schema::create('user_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('key');
            $table->string('value');
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
