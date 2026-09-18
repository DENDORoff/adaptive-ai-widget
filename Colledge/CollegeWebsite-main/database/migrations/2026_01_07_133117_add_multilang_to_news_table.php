<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('is_multilang')->default(false)->after('gallery');
        });

        
        $this->convertExistingNews();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        $this->revertNews();
        
        
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('is_multilang');
        });
    }

    
    private function convertExistingNews(): void
    {
        Log::info('🔄 Начинаем конвертацию новостей в многоязычный формат...');
        
        $news = DB::table('news')->get();
        $converted = 0;
        
        foreach ($news as $newsItem) {
            try {
                
                $multilangData = [
                    'title' => [
                        'ru' => $newsItem->title,
                        'kk' => '', 
                        'en' => '', 
                    ],
                    'excerpt' => [
                        'ru' => $newsItem->excerpt ?? '',
                        'kk' => '',
                        'en' => '',
                    ],
                    'content' => [
                        'ru' => $newsItem->content,
                        'kk' => '',
                        'en' => '',
                    ],
                ];
                
                
                DB::table('news')
                    ->where('id', $newsItem->id)
                    ->update([
                        'title' => json_encode($multilangData['title'], JSON_UNESCAPED_UNICODE),
                        'excerpt' => json_encode($multilangData['excerpt'], JSON_UNESCAPED_UNICODE),
                        'content' => json_encode($multilangData['content'], JSON_UNESCAPED_UNICODE),
                        'is_multilang' => true,
                    ]);
                
                $converted++;
                Log::info("  ✓ Конвертирована новость #{$newsItem->id}: {$newsItem->title}");
                
            } catch (\Exception $e) {
                Log::error("  ✗ Ошибка конвертации новости #{$newsItem->id}: {$e->getMessage()}");
            }
        }
        
        Log::info("✅ Конвертация завершена! Обработано новостей: {$converted}");
    }

    
    private function revertNews(): void
    {
        Log::info('🔙 Откат новостей к одноязычному формату...');
        
        $news = DB::table('news')
            ->where('is_multilang', true)
            ->get();
        
        $reverted = 0;
        
        foreach ($news as $newsItem) {
            try {
                
                $title = json_decode($newsItem->title, true);
                $excerpt = json_decode($newsItem->excerpt, true);
                $content = json_decode($newsItem->content, true);
                
                
                $titleRu = is_array($title) ? ($title['ru'] ?? $newsItem->title) : $newsItem->title;
                $excerptRu = is_array($excerpt) ? ($excerpt['ru'] ?? '') : ($newsItem->excerpt ?? '');
                $contentRu = is_array($content) ? ($content['ru'] ?? $newsItem->content) : $newsItem->content;
                
                
                DB::table('news')
                    ->where('id', $newsItem->id)
                    ->update([
                        'title' => $titleRu,
                        'excerpt' => $excerptRu,
                        'content' => $contentRu,
                    ]);
                
                $reverted++;
                Log::info("  ✓ Откачена новость #{$newsItem->id}");
                
            } catch (\Exception $e) {
                Log::error("  ✗ Ошибка отката новости #{$newsItem->id}: {$e->getMessage()}");
            }
        }
        
        Log::info("✅ Откат завершен! Обработано новостей: {$reverted}");
    }
};