<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youth_clubs', function (Blueprint $table) {
            $table->id();
            
            // Основная информация
            $table->string('name'); // Название кружка/секции
            $table->text('description'); // Описание
            $table->text('short_description')->nullable(); // Краткое описание
            
            // Визуальное оформление
            $table->string('icon')->default('fas fa-star'); // Font Awesome иконка
            $table->string('color')->default('blue'); // Цвет темы (blue, green, red, purple и т.д.)
            $table->string('image')->nullable(); // Изображение кружка
            
            // Категория
            $table->enum('category', [
                'sport',           // Спорт
                'art',             // Искусство
                'science',         // Наука
                'technology',      // Технологии
                'music',           // Музыка
                'dance',           // Танцы
                'theater',         // Театр
                'volunteer',       // Волонтерство
                'other'            // Другое
            ])->default('other');
            
            // Расписание и место
            $table->string('schedule')->nullable(); // Расписание занятий (текст)
            $table->string('location')->nullable(); // Место проведения
            $table->string('room')->nullable(); // Кабинет/помещение
            
            // Руководитель
            $table->string('instructor_name')->nullable(); // ФИО руководителя
            $table->string('instructor_phone')->nullable(); // Телефон
            $table->string('instructor_email')->nullable(); // Email
            $table->string('instructor_photo')->nullable(); // Фото руководителя
            
            // Параметры участия
            $table->integer('max_participants')->nullable(); // Макс. кол-во участников
            $table->integer('current_participants')->default(0); // Текущее кол-во
            $table->integer('age_min')->nullable(); // Минимальный возраст
            $table->integer('age_max')->nullable(); // Максимальный возраст
            $table->decimal('price', 10, 2)->default(0); // Стоимость (0 = бесплатно)
            
            // Дополнительная информация
            $table->json('achievements')->nullable(); // Достижения кружка
            $table->json('gallery')->nullable(); // Галерея фото
            $table->string('registration_link')->nullable(); // Ссылка на регистрацию
            
            // Статусы
            $table->boolean('is_recruiting')->default(true); // Идет набор
            $table->boolean('is_published')->default(false); // Опубликовано
            $table->boolean('is_featured')->default(false); // Избранное
            $table->integer('order')->default(0); // Порядок сортировки
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youth_clubs');
    }
};