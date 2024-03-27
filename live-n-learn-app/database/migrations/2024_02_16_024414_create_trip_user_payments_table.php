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
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('stripe_payment_method_id');
            $table->string('brand');
            $table->string('last4');
            $table->string('expiration');
            $table->timestamps();
        });

        Schema::create('user_school_trip_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_school_trip_id')->references('id')->on('user_school_trips');
            $table->string('stripe_payment_intent_id');
            $table->string('stripe_payment_method_id');
            $table->integer('amount');
            $table->string('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payment_methods');
        Schema::dropIfExists('trip_user_payments');
    }
};
