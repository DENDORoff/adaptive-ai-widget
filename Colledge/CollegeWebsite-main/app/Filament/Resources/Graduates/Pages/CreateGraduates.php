<?php

namespace App\Filament\Resources\Graduates\Pages;

use App\Filament\Resources\Graduates\GraduatesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGraduates extends CreateRecord
{
    protected static string $resource = GraduatesResource::class;

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
            
            $data['specialty'] = json_encode([
                'ru' => $data['specialty_ru'] ?? '',
                'kk' => $data['specialty_kk'] ?? '',
                'en' => $data['specialty_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['position'] = json_encode([
                'ru' => $data['position_ru'] ?? '',
                'kk' => $data['position_kk'] ?? '',
                'en' => $data['position_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['story'] = json_encode([
                'ru' => $data['story_ru'] ?? '',
                'kk' => $data['story_kk'] ?? '',
                'en' => $data['story_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $companyRu = $data['company_ru'] ?? '';
            $companyKk = $data['company_kk'] ?? '';
            $companyEn = $data['company_en'] ?? '';
            
            if (!empty($companyRu) || !empty($companyKk) || !empty($companyEn)) {
                $data['company'] = json_encode([
                    'ru' => $companyRu,
                    'kk' => $companyKk,
                    'en' => $companyEn,
                ], JSON_UNESCAPED_UNICODE);
            }
            
            $fieldsToUnset = [
                'name_ru', 'name_kk', 'name_en',
                'specialty_ru', 'specialty_kk', 'specialty_en',
                'position_ru', 'position_kk', 'position_en',
                'story_ru', 'story_kk', 'story_en',
            ];
            
            if (isset($data['company_ru'])) $fieldsToUnset[] = 'company_ru';
            if (isset($data['company_kk'])) $fieldsToUnset[] = 'company_kk';
            if (isset($data['company_en'])) $fieldsToUnset[] = 'company_en';
            
            foreach ($fieldsToUnset as $field) {
                unset($data[$field]);
            }
        } else {
            if (empty($data['name'] ?? '')) {
                $data['name'] = 'Выпускник';
            }
            if (empty($data['specialty'] ?? '')) {
                $data['specialty'] = '';
            }
            if (empty($data['position'] ?? '')) {
                $data['position'] = '';
            }
            if (empty($data['story'] ?? '')) {
                $data['story'] = '';
            }
            if (empty($data['company'] ?? '')) {
                $data['company'] = '';
            }
        }
        
        return $data;
    }
}