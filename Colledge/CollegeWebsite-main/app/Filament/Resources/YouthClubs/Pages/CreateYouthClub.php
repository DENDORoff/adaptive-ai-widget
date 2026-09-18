<?php

namespace App\Filament\Resources\YouthClubs\Pages;

use App\Filament\Resources\YouthClubs\YouthClubResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYouthClub extends CreateRecord
{
    protected static string $resource = YouthClubResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return self::processFormData($data);
    }

    public static function processFormData(array $data): array
    {
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $data['name'] = json_encode([
                'ru' => $data['name_ru'] ?? '',
                'kk' => $data['name_kk'] ?? '',
                'en' => $data['name_en'] ?? '',
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
            
            if (isset($data['schedule_ru']) || isset($data['schedule_kk']) || isset($data['schedule_en'])) {
                $data['schedule'] = json_encode([
                    'ru' => $data['schedule_ru'] ?? '',
                    'kk' => $data['schedule_kk'] ?? '',
                    'en' => $data['schedule_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            if (isset($data['location_ru']) || isset($data['location_kk']) || isset($data['location_en'])) {
                $data['location'] = json_encode([
                    'ru' => $data['location_ru'] ?? '',
                    'kk' => $data['location_kk'] ?? '',
                    'en' => $data['location_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            if (isset($data['room_ru']) || isset($data['room_kk']) || isset($data['room_en'])) {
                $data['room'] = json_encode([
                    'ru' => $data['room_ru'] ?? '',
                    'kk' => $data['room_kk'] ?? '',
                    'en' => $data['room_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            if (isset($data['instructor_name_ru']) || isset($data['instructor_name_kk']) || isset($data['instructor_name_en'])) {
                $data['instructor_name'] = json_encode([
                    'ru' => $data['instructor_name_ru'] ?? '',
                    'kk' => $data['instructor_name_kk'] ?? '',
                    'en' => $data['instructor_name_en'] ?? '',
                ], JSON_UNESCAPED_UNICODE);
            }
            
            $fieldsToUnset = [
                'name_ru', 'name_kk', 'name_en',
                'short_description_ru', 'short_description_kk', 'short_description_en',
                'description_ru', 'description_kk', 'description_en',
            ];
            
            $additionalFields = [
                'schedule_ru', 'schedule_kk', 'schedule_en',
                'location_ru', 'location_kk', 'location_en',
                'room_ru', 'room_kk', 'room_en',
                'instructor_name_ru', 'instructor_name_kk', 'instructor_name_en',
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
            if (empty($data['name'] ?? '')) {
                $data['name'] = 'Кружок';
            }
            if (empty($data['short_description'] ?? '')) {
                $data['short_description'] = '';
            }
            if (empty($data['description'] ?? '')) {
                $data['description'] = '';
            }
            if (empty($data['schedule'] ?? '')) {
                $data['schedule'] = '';
            }
            if (empty($data['location'] ?? '')) {
                $data['location'] = '';
            }
            if (empty($data['room'] ?? '')) {
                $data['room'] = '';
            }
            if (empty($data['instructor_name'] ?? '')) {
                $data['instructor_name'] = '';
            }
        }
        
        return $data;
    }
}