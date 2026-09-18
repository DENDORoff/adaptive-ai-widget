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
        Schema::create('curators', function (Blueprint $table) {
            $table->id();
            
            // Информация о кураторе
            $table->string('curator_name'); // ФИО куратора
            $table->string('curator_position')->nullable(); // Должность
            $table->string('curator_email')->nullable(); // Email
            $table->string('curator_phone')->nullable(); // Телефон
            $table->string('curator_photo')->nullable(); // Фото
            
            // Информация о группе
            $table->string('group_name'); // Например: "ИС-21-1"
            $table->string('specialty'); // Специальность группы
            $table->integer('course')->default(1); // Курс (1-4)
            $table->integer('students_count')->nullable(); // Количество студентов
            
            // Контактная информация
            $table->string('room_number')->nullable(); // Номер кабинета
            $table->text('consultation_schedule')->nullable(); // Расписание консультаций
            $table->text('additional_info')->nullable(); // Дополнительная информация
            
            // Настройки отображения
            $table->integer('order')->default(0); // Порядок сортировки
            $table->boolean('is_active')->default(true); // Активность
            
            $table->timestamps();
            
            // Индексы для быстрого поиска
            $table->index('course');
            $table->index('is_active');
            $table->index('curator_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curators');
    }
};