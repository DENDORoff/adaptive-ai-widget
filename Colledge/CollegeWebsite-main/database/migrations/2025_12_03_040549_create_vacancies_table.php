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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            
            // Основная информация
            $table->string('title'); // Название вакансии
            $table->string('slug')->unique(); // URL-friendly название
            $table->text('description'); // Краткое описание для виджета
            
            // Детали вакансии
            $table->string('salary')->nullable(); // Зарплата
            $table->string('location')->nullable(); // Местоположение
            $table->string('employment_type')->nullable(); // Тип занятости (полная, частичная и т.д.)
            
            // PDF файл
            $table->string('pdf_file'); // Путь к PDF файлу
            
            // Публикация
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable(); // Дата публикации
            $table->timestamp('expires_at')->nullable(); // Дата истечения вакансии
            
            // Сортировка
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Индексы
            $table->index('is_published');
            $table->index('published_at');
            $table->index('expires_at');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};