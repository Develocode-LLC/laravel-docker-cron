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
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->double('fees', 8, 2)->nullable()->after('amount');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->boolean('primary')->default(1)->after('line_total');
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
