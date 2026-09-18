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

            $table->text('position')->nullable()->change();
            $table->text('specialty')->nullable()->change();
            $table->text('diploma_specialty')->nullable()->change();
            $table->text('diploma_qualification')->nullable()->change();
            $table->text('work_experience_total')->nullable()->change();
            $table->text('work_experience_pedagogical')->nullable()->change();
            $table->text('category')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('position', 255)->nullable()->change();
            $table->string('specialty', 255)->nullable()->change();
            $table->string('diploma_specialty', 255)->nullable()->change();
            $table->string('diploma_qualification', 255)->nullable()->change();
            $table->string('work_experience_total', 255)->nullable()->change();
            $table->string('work_experience_pedagogical', 255)->nullable()->change();
            $table->string('category', 255)->nullable()->change();
        });
    }
};
