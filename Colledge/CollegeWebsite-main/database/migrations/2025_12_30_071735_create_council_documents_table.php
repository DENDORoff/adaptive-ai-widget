<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('council_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('council_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Название документа
            $table->string('file_path'); // Путь к PDF файлу
            $table->string('file_size')->nullable(); // Размер файла (например: "2.4 МБ")
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_visible')->default(true); // Видимость документа
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('council_documents');
    }
};