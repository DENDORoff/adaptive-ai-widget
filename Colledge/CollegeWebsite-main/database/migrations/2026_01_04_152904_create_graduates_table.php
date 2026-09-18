<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ФИО выпускника
            $table->string('slug')->unique(); // URL-friendly
            $table->string('specialty'); // Специальность
            $table->string('position'); // Текущая должность
            $table->text('story'); // История успеха
            $table->string('photo')->nullable(); // Фото выпускника
            $table->string('graduation_year')->nullable(); // Год выпуска
            $table->string('company')->nullable(); // Компания работы
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_active')->default(true); // Активно/неактивно
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};