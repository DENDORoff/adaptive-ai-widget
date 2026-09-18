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
        Schema::create('bug_reports', function (Blueprint $table) {
            $table->id();
            
            // Контактная информация
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            
            // Техническая информация
            $table->string('page_url')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable(); // desktop, mobile, tablet
            
            // Информация об ошибке
            $table->string('title');
            $table->text('description');
            $table->json('steps_to_reproduce')->nullable(); // Шаги для воспроизведения
            $table->text('expected_result')->nullable();
            $table->text('actual_result')->nullable();
            
            // Статус и приоритет
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['new', 'in_progress', 'resolved', 'need_more_info', 'cannot_reproduce'])->default('new');
            
            // Ответ администратора
            $table->text('admin_comment')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            $table->timestamps();
            
            // Индексы
            $table->index('status');
            $table->index('priority');
            $table->index('created_at');
            $table->index(['status', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bug_reports');
    }
};