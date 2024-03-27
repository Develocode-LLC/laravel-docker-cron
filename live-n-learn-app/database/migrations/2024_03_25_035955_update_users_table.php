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
            $table->string('preferred_pronouns')->nullable()->after('gender_identity');
            $table->string('preferred_pronouns_other')->nullable()->after('preferred_pronouns');
            $table->foreignId('school_id')->nullable()->references('id')->on('schools');
            $table->enum('grade', ['7', '8', '9', '10', '11', '12'])->nullable();
            $table->string('host_family_request')->nullable();
            $table->string('follows_diet')->nullable()->change();
            $table->string('eats_seafood')->nullable()->change();
            $table->string('eats_seafood_details')->nullable();
            $table->tinyInteger('college_credit')->nullable();
            $table->tinyInteger('scholarships')->nullable();
            $table->tinyInteger('previously_hosted')->nullable();
            $table->unsignedInteger('previously_hosted_year')->nullable();
        });

        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('contact_type', ['parent_guardian','emergency'])->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('relationship');
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
