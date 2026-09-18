<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::table('page_sections', function (Blueprint $table) {
            $table->boolean('is_multilang')->default(false)->after('content');
        });

        
        $this->convertExistingData();
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn('is_multilang');
        });
    }

    private function convertExistingData(): void
    {
        $sections = DB::table('page_sections')->get();
        
        foreach ($sections as $section) {
            if (!$section->content) continue;
            
            $content = json_decode($section->content, true);
            if (!$content) continue;
            
            
            $multilangContent = [];
            foreach ($content as $key => $value) {
                if (is_string($value)) {
                    $multilangContent[$key] = [
                        'ru' => $value,
                        'kk' => '', 
                        'en' => '', 
                    ];
                } else {
                    $multilangContent[$key] = $value;
                }
            }
            
            DB::table('page_sections')
                ->where('id', $section->id)
                ->update([
                    'content' => json_encode($multilangContent),
                    'is_multilang' => true,
                ]);
        }
    }
};