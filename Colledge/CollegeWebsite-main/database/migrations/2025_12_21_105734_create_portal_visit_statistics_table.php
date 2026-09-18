<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_visit_statistics', function (Blueprint $table) {
            $table->id();
            
            // Дата статистики
            $table->date('date')->unique();
            
            // Данные из Яндекс.Метрики
            $table->integer('visitors')->default(0); // Посетители
            $table->integer('views')->default(0); // Просмотры
            $table->integer('unique_visitors')->default(0); // Уникальные посетители
            $table->integer('new_visitors')->default(0); // Новые посетители
            $table->decimal('bounce_rate', 5, 2)->nullable(); // Показатель отказов %
            $table->integer('avg_visit_duration')->nullable(); // Средняя длительность визита (сек)
            $table->decimal('page_depth', 5, 2)->nullable(); // Глубина просмотра
            
            // Метаданные
            $table->timestamp('synced_at')->nullable(); // Когда синхронизировано
            $table->string('sync_status')->default('pending'); // pending, synced, error
            $table->text('sync_error')->nullable(); // Ошибка синхронизации
            
            $table->timestamps();
            
            // Индексы
            $table->index('date');
            $table->index('sync_status');
            $table->index('synced_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_visit_statistics');
    }
};