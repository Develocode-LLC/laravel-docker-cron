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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_initiated_id')->references('id')->on('messages');
            $table->string('subject');
            $table->timestamps();
        });

        Schema::create('message_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->references('id')->on('messages');
            $table->foreignId('author_id')->references('id')->on('users');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('message_conversation_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_conversation_id')->references('id')->on('message_conversations');
            $table->text('file_location');
            $table->timestamps();
        });

        Schema::create('message_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->references('id')->on('messages');
            $table->foreignId('recipient_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_conversation_files');
        Schema::dropIfExists('message_recipients');
        Schema::dropIfExists('message_conversations');
        Schema::dropIfExists('messages');
    }
};
