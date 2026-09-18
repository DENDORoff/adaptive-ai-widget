<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            
            // Идентификация страницы и секции
            $table->string('page_key')->index(); // home, about, contacts и т.д.
            $table->string('section_key')->index(); // hero, stats, features и т.д.
            $table->string('title')->nullable(); // Название секции в админке
            
            // Контент
            $table->json('content')->nullable(); // Весь контент в JSON
            $table->text('description')->nullable(); // Описание для админов
            
            // Настройки
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            // SEO (опционально для страниц)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            $table->timestamps();
            
            // Уникальный ключ: одна секция на странице
            $table->unique(['page_key', 'section_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};