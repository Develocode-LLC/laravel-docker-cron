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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('recipient_id')->references('id')->on('users');
            $table->foreignId('created_by_id')->references('id')->on('users');
            $table->foreignId('trip_id')->nullable()->references('id')->on('trips');
            $table->date('due_date');
            $table->double('amount_due', 8, 2);
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->references('id')->on('invoices');
            $table->string('name');
            $table->text('description');
            $table->double('line_total', 8, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
