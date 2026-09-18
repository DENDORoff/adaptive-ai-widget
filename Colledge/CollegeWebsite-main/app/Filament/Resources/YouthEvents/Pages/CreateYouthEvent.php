<?php

namespace App\Filament\Resources\YouthEvents\Pages;

use App\Filament\Resources\YouthEvents\YouthEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYouthEvent extends CreateRecord
{
    protected static string $resource = YouthEventResource::class;

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
            
            $data['short_description'] = json_encode([
                'ru' => $data['short_description_ru'] ?? '',
                'kk' => $data['short_description_kk'] ?? '',
                'en' => $data['short_description_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['description'] = json_encode([
                'ru' => $data['description_ru'] ?? '',
                'kk' => $data['description_kk'] ?? '',
                'en' => $data['description_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            if (isset($data['location_ru']) || isset($data['location_kk']) || isset($data['location_en'])) {
                $data['location'] = json_encode([
                    'ru' => $data['location_ru'] ?? '',
                    'kk' => $data['location_kk'] ?? '',
                    'en' => $data['location_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            if (isset($data['organizer_ru']) || isset($data['organizer_kk']) || isset($data['organizer_en'])) {
                $data['organizer'] = json_encode([
                    'ru' => $data['organizer_ru'] ?? '',
                    'kk' => $data['organizer_kk'] ?? '',
                    'en' => $data['organizer_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            $fieldsToUnset = [
                'title_ru', 'title_kk', 'title_en',
                'short_description_ru', 'short_description_kk', 'short_description_en',
                'description_ru', 'description_kk', 'description_en',
            ];
            
            if (isset($data['location_ru'])) $fieldsToUnset[] = 'location_ru';
            if (isset($data['location_kk'])) $fieldsToUnset[] = 'location_kk';
            if (isset($data['location_en'])) $fieldsToUnset[] = 'location_en';
            
            if (isset($data['organizer_ru'])) $fieldsToUnset[] = 'organizer_ru';
            if (isset($data['organizer_kk'])) $fieldsToUnset[] = 'organizer_kk';
            if (isset($data['organizer_en'])) $fieldsToUnset[] = 'organizer_en';
            
            foreach ($fieldsToUnset as $field) {
                unset($data[$field]);
            }
        } else {
            if (empty($data['title'] ?? '')) {
                $data['title'] = 'Событие';
            }
            if (empty($data['short_description'] ?? '')) {
                $data['short_description'] = '';
            }
            if (empty($data['description'] ?? '')) {
                $data['description'] = '';
            }
            if (empty($data['location'] ?? '')) {
                $data['location'] = '';
            }
            if (empty($data['organizer'] ?? '')) {
                $data['organizer'] = '';
            }
        }
        
        return $data;
    }
}