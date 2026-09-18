<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anticorruption_documents', function (Blueprint $table) {
            
            $table->text('title')->change();
            $table->text('description')->change();
            
            
            $table->boolean('is_multilang')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('anticorruption_documents', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->change();
            $table->dropColumn('is_multilang');
        });
    }
};