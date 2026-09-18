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
        Schema::table('staff', function (Blueprint $table) {
            // Образование
            $table->text('education')->nullable()->after('specialty'); // Образование, год окончания
            $table->string('diploma_specialty')->nullable()->after('education'); // Специальность по диплому
            $table->string('diploma_qualification')->nullable()->after('diploma_specialty'); // Квалификация по диплому
            
            // Преподавание
            $table->text('teaching_subjects')->nullable()->after('diploma_qualification'); // Какой предмет (дисциплину) ведет
            
            // Стаж работы
            $table->string('work_experience_total')->nullable()->after('teaching_subjects'); // Общий стаж
            $table->string('work_experience_pedagogical')->nullable()->after('work_experience_total'); // Педагогический стаж
            
            // Категория и достижения
            $table->string('category')->nullable()->after('work_experience_pedagogical'); // Категория
            $table->text('awards')->nullable()->after('category'); // Награды
            $table->text('professional_development')->nullable()->after('awards'); // Курсы повышения квалификации
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn([
                'education',
                'diploma_specialty',
                'diploma_qualification',
                'teaching_subjects',
                'work_experience_total',
                'work_experience_pedagogical',
                'category',
                'awards',
                'professional_development',
            ]);
        });
    }
};