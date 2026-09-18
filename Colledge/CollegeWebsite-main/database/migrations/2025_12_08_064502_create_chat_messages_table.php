<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index(); // ID сессии пользователя
            $table->string('user_name')->nullable(); // Имя пользователя (если указал)
            $table->string('user_email')->nullable(); // Email пользователя
            $table->text('message'); // Текст сообщения
            $table->boolean('is_admin')->default(false); // От админа или от пользователя
            $table->boolean('is_read')->default(false); // Прочитано ли
            $table->string('status')->default('pending'); // pending, answered, closed
            $table->timestamps();
        });

        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_ip')->nullable();
            $table->string('status')->default('active'); // active, closed
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};