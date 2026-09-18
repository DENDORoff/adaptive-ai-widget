<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HistoryTimeline;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('history_timelines', function (Blueprint $table) {
            $table->string('position')->default('left')->after('is_active');
        });

        // Обновим существующие записи
        HistoryTimeline::query()->update(['position' => 'left']);
    }

    public function down(): void
    {
        Schema::table('history_timelines', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};