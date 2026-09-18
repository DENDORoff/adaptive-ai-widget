<?php

namespace App\Filament\Resources\YouthAnnouncements\Pages;

use App\Filament\Resources\YouthAnnouncements\YouthAnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYouthAnnouncement extends CreateRecord
{
    protected static string $resource = YouthAnnouncementResource::class;

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
            
            $data['content'] = json_encode([
                'ru' => $data['content_ru'] ?? '',
                'kk' => $data['content_kk'] ?? '',
                'en' => $data['content_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            if (isset($data['action_text_ru']) || isset($data['action_text_kk']) || isset($data['action_text_en'])) {
                $data['action_text'] = json_encode([
                    'ru' => $data['action_text_ru'] ?? '',
                    'kk' => $data['action_text_kk'] ?? '',
                    'en' => $data['action_text_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            $fieldsToUnset = [
                'title_ru', 'title_kk', 'title_en',
                'content_ru', 'content_kk', 'content_en',
            ];
            
            $additionalFields = [
                'action_text_ru', 'action_text_kk', 'action_text_en',
            ];
            
            foreach ($additionalFields as $field) {
                if (isset($data[$field])) {
                    $fieldsToUnset[] = $field;
                }
            }
            
            foreach ($fieldsToUnset as $field) {
                unset($data[$field]);
            }
        } else {
            if (empty($data['title'] ?? '')) {
                $data['title'] = 'Объявление';
            }
            if (empty($data['content'] ?? '')) {
                $data['content'] = '';
            }
            if (empty($data['action_text'] ?? '')) {
                $data['action_text'] = '';
            }
        }
        
        return $data;
    }
}