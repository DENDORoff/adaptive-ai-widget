<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('government_service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('file_path');
            $table->enum('document_type', ['info', 'form', 'regulation', 'instruction', 'other'])->default('info');
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            $table->index(['government_service_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_documents');
    }
};