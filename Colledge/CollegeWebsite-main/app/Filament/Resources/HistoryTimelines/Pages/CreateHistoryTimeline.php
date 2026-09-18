<?php

namespace App\Filament\Resources\HistoryTimelines\Pages;

use App\Filament\Resources\HistoryTimelines\HistoryTimelineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHistoryTimeline extends CreateRecord
{
    protected static string $resource = HistoryTimelineResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return self::processFormData($data);
    }

    public static function processFormData(array $data): array
    {
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $data['title'] = json_encode([
                'ru' => $data['title_ru'] ?? '',
                'kk' => $data['title_kk'] ?? '',
                'en' => $data['title_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['description'] = json_encode([
                'ru' => $data['description_ru'] ?? '',
                'kk' => $data['description_kk'] ?? '',
                'en' => $data['description_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            unset(
                $data['title_ru'], $data['title_kk'], $data['title_en'],
                $data['description_ru'], $data['description_kk'], $data['description_en']
            );
        } else {
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Событие';
            }
            if (!isset($data['description']) || empty($data['description'])) {
                $data['description'] = '';
            }
        }
        
        return $data;
    }
}