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
            $table->enum('class', [
                'administrator', 
                'host_family', 
                'local_coordinator', 
                'group_leader', 
                'traveler', 
                'inbound_partner', 
                'outbound_partner',
                'parent'
            ])->change();
            $table->string('account_number')->unique()->nullable()->after('class');
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
