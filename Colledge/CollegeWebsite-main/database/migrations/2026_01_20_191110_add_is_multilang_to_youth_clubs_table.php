<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('youth_clubs', function (Blueprint $table) {
            $table->boolean('is_multilang')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('youth_clubs', function (Blueprint $table) {
            $table->dropColumn('is_multilang');
        });
    }
};