<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youth_events', function (Blueprint $table) {
            $table->id();
            
            // Основная информация
            $table->string('title'); // Название события
            $table->text('description'); // Описание
            $table->text('short_description')->nullable(); // Краткое описание для карточки
            
            // Медиа
            $table->string('image')->nullable(); // Главное изображение
            $table->json('gallery')->nullable(); // Галерея изображений
            
            // Даты и время
            $table->dateTime('event_date'); // Дата проведения
            $table->string('event_time')->nullable(); // Время проведения (текст)
            $table->string('location')->nullable(); // Место проведения
            
            // Типы событий
            $table->enum('type', ['week_event', 'upcoming', 'archive'])
                ->default('upcoming'); // week_event - событие недели, upcoming - ближайшие, archive - архив
            
            // Статистика
            $table->integer('participants_count')->default(0); // Количество участников
            $table->string('organizer')->nullable(); // Организатор
            
            // Дополнительные данные
            $table->json('tags')->nullable(); // Теги события
            $table->string('registration_link')->nullable(); // Ссылка на регистрацию
            
            // Статусы
            $table->boolean('is_featured')->default(false); // Избранное (событие недели)
            $table->boolean('is_published')->default(false); // Опубликовано
            $table->integer('order')->default(0); // Порядок сортировки
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youth_events');
    }
};