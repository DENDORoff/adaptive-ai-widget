<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->boolean('is_multilang')->default(false)->after('order');
        });

        
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE staff ALTER COLUMN full_name TYPE jsonb USING (to_jsonb(full_name))');
            DB::statement('ALTER TABLE staff ALTER COLUMN position TYPE jsonb USING (to_jsonb(position))');
            DB::statement('ALTER TABLE staff ALTER COLUMN bio TYPE jsonb USING (to_jsonb(bio))');
            DB::statement('ALTER TABLE staff ALTER COLUMN specialty TYPE jsonb USING (to_jsonb(specialty))');
            DB::statement('ALTER TABLE staff ALTER COLUMN education TYPE jsonb USING (to_jsonb(education))');
            DB::statement('ALTER TABLE staff ALTER COLUMN diploma_specialty TYPE jsonb USING (to_jsonb(diploma_specialty))');
            DB::statement('ALTER TABLE staff ALTER COLUMN diploma_qualification TYPE jsonb USING (to_jsonb(diploma_qualification))');
            DB::statement('ALTER TABLE staff ALTER COLUMN teaching_subjects TYPE jsonb USING (to_jsonb(teaching_subjects))');
            DB::statement('ALTER TABLE staff ALTER COLUMN work_experience_total TYPE jsonb USING (to_jsonb(work_experience_total))');
            DB::statement('ALTER TABLE staff ALTER COLUMN work_experience_pedagogical TYPE jsonb USING (to_jsonb(work_experience_pedagogical))');
            DB::statement('ALTER TABLE staff ALTER COLUMN category TYPE jsonb USING (to_jsonb(category))');
            DB::statement('ALTER TABLE staff ALTER COLUMN awards TYPE jsonb USING (to_jsonb(awards))');
            DB::statement('ALTER TABLE staff ALTER COLUMN professional_development TYPE jsonb USING (to_jsonb(professional_development))');
        } else {
            
            Schema::table('staff', function (Blueprint $table) {
                $table->json('full_name')->nullable()->change();
                $table->json('position')->nullable()->change();
                $table->json('bio')->nullable()->change();
                $table->json('specialty')->nullable()->change();
                $table->json('education')->nullable()->change();
                $table->json('diploma_specialty')->nullable()->change();
                $table->json('diploma_qualification')->nullable()->change();
                $table->json('teaching_subjects')->nullable()->change();
                $table->json('work_experience_total')->nullable()->change();
                $table->json('work_experience_pedagogical')->nullable()->change();
                $table->json('category')->nullable()->change();
                $table->json('awards')->nullable()->change();
                $table->json('professional_development')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn('is_multilang');
            
            
            $table->string('full_name')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->text('bio')->nullable()->change();
            $table->string('specialty')->nullable()->change();
            $table->text('education')->nullable()->change();
            $table->string('diploma_specialty')->nullable()->change();
            $table->string('diploma_qualification')->nullable()->change();
            $table->text('teaching_subjects')->nullable()->change();
            $table->string('work_experience_total')->nullable()->change();
            $table->string('work_experience_pedagogical')->nullable()->change();
            $table->string('category')->nullable()->change();
            $table->text('awards')->nullable()->change();
            $table->text('professional_development')->nullable()->change();
        });
    }
};