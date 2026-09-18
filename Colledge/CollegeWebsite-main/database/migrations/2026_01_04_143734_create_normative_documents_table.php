<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('normative_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название документа
            $table->string('slug')->unique(); // URL-friendly идентификатор
            $table->string('document_id')->unique(); // ID для фронтенда (document1, document2...)
            $table->text('description')->nullable(); // Описание документа
            $table->string('pdf_file'); // Путь к PDF файлу
            $table->string('file_size')->nullable(); // Размер файла (1.2 MB)
            $table->integer('pages')->default(1); // Количество страниц
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_published')->default(true); // Опубликован ли
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('normative_documents');
    }
};