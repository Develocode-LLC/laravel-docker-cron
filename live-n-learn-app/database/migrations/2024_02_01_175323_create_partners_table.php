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
            $table->enum('class', ['administrator', 'host_family', 'local_coordinator', 'group_leader', 'traveler'])->change();
        });

        /*
            partner_type: (Inbound, Outbound, Both)
            partner_name
            address1
            address2
            city
            state
            postal_code
            country
            country_phone_code
            phone_number
        */
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Inbound', 'Outbound', 'Both']);
            $table->string('name');
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_phone_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
