<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название достижения
            $table->string('slug')->unique(); // URL-friendly
            $table->text('description'); // Описание
            $table->string('icon')->default('trophy'); // Иконка (trophy, medal, certificate, lab, briefcase, handshake)
            $table->string('year')->default('2024'); // Год получения
            $table->string('status')->default('Актуально'); // Статус (Актуально, Архив)
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_active')->default(true); // Активно/неактивно
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};