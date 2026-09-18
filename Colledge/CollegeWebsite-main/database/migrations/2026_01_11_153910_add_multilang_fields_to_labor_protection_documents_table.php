<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('labor_protection_documents', function (Blueprint $table) {
            $table->boolean('is_multilang')->default(false)->after('is_published');
            $table->timestamp('published_at')->nullable()->after('is_multilang');
        });
    }

    public function down(): void
    {
        Schema::table('labor_protection_documents', function (Blueprint $table) {
            $table->dropColumn(['is_multilang', 'published_at']);
        });
    }
};