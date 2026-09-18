<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youth_announcements', function (Blueprint $table) {
            $table->id();
            
            // Основная информация
            $table->string('title'); // Заголовок объявления
            $table->text('content'); // Содержание объявления
            
            // Визуальное оформление
            $table->enum('type', ['info', 'warning', 'success', 'danger'])
                ->default('info'); // Тип объявления (влияет на цвет)
            $table->string('icon')->default('fas fa-bullhorn'); // Font Awesome иконка
            
            // Даты
            $table->dateTime('published_at')->nullable(); // Дата публикации
            $table->dateTime('expires_at')->nullable(); // Дата истечения (автоматически скрывается)
            
            // Приоритет и видимость
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])
                ->default('normal'); // Приоритет объявления
            $table->boolean('is_pinned')->default(false); // Закрепленное
            $table->boolean('is_published')->default(false); // Опубликовано
            $table->integer('order')->default(0); // Порядок сортировки
            
            // Дополнительно
            $table->string('action_url')->nullable(); // Ссылка на действие
            $table->string('action_text')->nullable(); // Текст кнопки действия
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youth_announcements');
    }
};