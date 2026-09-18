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
        Schema::create('college_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->enum('type', ['charter', 'license', 'rules'])->default('charter');
            $table->string('pdf_file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Индексы для оптимизации запросов
            $table->index(['type', 'is_active']);
            $table->index(['is_active', 'order']);
            $table->index(['order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_documents');
    }
};