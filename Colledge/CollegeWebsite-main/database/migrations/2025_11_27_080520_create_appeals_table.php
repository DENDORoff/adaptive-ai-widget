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
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            
            // Контактная информация отправителя
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            
            // Информация об обращении
            $table->string('category'); // Категория обращения (Жалоба/Другое)
            $table->string('subject'); // Адресат обращения
            $table->text('message'); // Текст обращения
            $table->string('file_path')->nullable(); // Прикрепленный файл
            
            // Статус и ответ
            $table->enum('status', ['new', 'in_progress', 'completed'])->default('new');
            $table->text('admin_response')->nullable(); // Ответ администратора
            $table->timestamp('responded_at')->nullable(); // Дата ответа
            
            $table->timestamps();
            
            // Индексы
            $table->index('status');
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};