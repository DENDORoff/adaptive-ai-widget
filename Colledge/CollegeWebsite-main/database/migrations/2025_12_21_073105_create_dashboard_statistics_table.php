<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('dashboard_statistics')) {
            Schema::create('dashboard_statistics', function (Blueprint $table) {
                $table->id();
                
                $table->string('key')->unique()->index(); 
                $table->string('category'); 
                $table->string('value'); 
                
                $table->string('formatted_value')->nullable()->after('value');
                $table->string('formatted_growth')->nullable()->after('formatted_value'); 
                
                $table->string('label')->nullable(); 
                $table->text('description')->nullable(); 
                
                $table->decimal('previous_value', 15, 2)->nullable(); 
                $table->decimal('growth_percentage', 8, 2)->nullable(); 
                $table->boolean('auto_calculate_growth')->default(false); 
                
                $table->boolean('is_auto_updated')->default(false); 
                $table->string('update_source')->nullable(); 
                $table->timestamp('last_updated_at')->nullable(); 
                
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                
                $table->string('unit', 50)->nullable(); 
                $table->string('data_type', 20)->default('number'); 
                $table->boolean('show_growth')->default(true); 
                $table->boolean('is_public')->default(true); 
                
                $table->timestamps();
            });
        } else {
            Schema::table('dashboard_statistics', function (Blueprint $table) {
                
                if (!Schema::hasColumn('dashboard_statistics', 'formatted_value')) {
                    $table->string('formatted_value')->nullable()->after('value');
                }
                
                if (!Schema::hasColumn('dashboard_statistics', 'formatted_growth')) {
                    $table->string('formatted_growth')->nullable()->after('formatted_value');
                }
                
                if (!Schema::hasColumn('dashboard_statistics', 'unit')) {
                    $table->string('unit', 50)->nullable()->after('formatted_growth');
                }
                
                if (!Schema::hasColumn('dashboard_statistics', 'data_type')) {
                    $table->string('data_type', 20)->default('number')->after('unit');
                }
                
                if (!Schema::hasColumn('dashboard_statistics', 'show_growth')) {
                    $table->boolean('show_growth')->default(true)->after('data_type');
                }
                
                if (!Schema::hasColumn('dashboard_statistics', 'is_public')) {
                    $table->boolean('is_public')->default(true)->after('show_growth');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('dashboard_statistics', function (Blueprint $table) {
            $columns = [
                'formatted_value',
                'formatted_growth',
                'unit',
                'data_type',
                'show_growth',
                'is_public'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('dashboard_statistics', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        
    }
};