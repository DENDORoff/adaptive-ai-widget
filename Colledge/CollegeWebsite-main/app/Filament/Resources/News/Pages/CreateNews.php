<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::info('=== mutateFormDataBeforeCreate called ===');
        \Log::info('Data before create:', $data);
        
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $data['title'] = json_encode([
                'ru' => $data['title_ru'] ?? '',
                'kk' => $data['title_kk'] ?? '',
                'en' => $data['title_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['excerpt'] = json_encode([
                'ru' => $data['excerpt_ru'] ?? '',
                'kk' => $data['excerpt_kk'] ?? '',
                'en' => $data['excerpt_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['content'] = json_encode([
                'ru' => $data['content_ru'] ?? '',
                'kk' => $data['content_kk'] ?? '',
                'en' => $data['content_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            \Log::info('JSON created:', [
                'title' => $data['title'],
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
            ]);
            
            // НЕ удаляем временные поля формы
            // unset(
            //     $data['title_ru'], $data['title_kk'], $data['title_en'],
            //     $data['excerpt_ru'], $data['excerpt_kk'], $data['excerpt_en'],
            //     $data['content_ru'], $data['content_kk'], $data['content_en']
            // );
        } else {
            // Для не многоязычного режима
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Без заголовка';
            }
        }
        
        return $data;
    }
}