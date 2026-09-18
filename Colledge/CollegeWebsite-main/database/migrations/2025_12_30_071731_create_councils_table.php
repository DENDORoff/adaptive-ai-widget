<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('councils', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название совета
            $table->text('description'); // Описание
            $table->string('icon')->default('fas fa-users'); // Font Awesome иконка
            $table->string('chairman')->nullable(); // Председатель
            $table->string('meeting_frequency')->default('1 раз в месяц'); // Частота заседаний
            $table->string('work_period')->default('2023-2024 учебный год'); // Период работы
            $table->string('contact_email')->nullable(); // Email для связи
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_active')->default(true); // Активен ли совет
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('councils');
    }
};