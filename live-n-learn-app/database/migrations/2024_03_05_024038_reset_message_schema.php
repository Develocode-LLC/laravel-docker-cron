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
        Schema::dropIfExists('message_conversation_files');
        Schema::dropIfExists('message_recipients');
        Schema::dropIfExists('message_conversations');
        Schema::dropIfExists('messages');


        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->references('id')->on('users');
            $table->foreignId('recipient_id')->references('id')->on('users');
            $table->string('subject');
            $table->text('message');
            $table->date('message_send_date');
            $table->boolean('sent');
            $table->timestamps();
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
