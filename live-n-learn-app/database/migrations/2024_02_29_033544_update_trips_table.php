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
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['partner_id']);
            $table->dropColumn('school_id');
            $table->dropColumn('partner_id');
        });


        Schema::table('trips', function (Blueprint $table) {
            $table->double('total_cost', 8, 2)->nullable()->change();
            $table->foreignId('school_id')->nullable()->after('id')->references('id')->on('schools');
            $table->foreignId('partner_id')->nullable()->after('school_id')->references('id')->on('partners');
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
