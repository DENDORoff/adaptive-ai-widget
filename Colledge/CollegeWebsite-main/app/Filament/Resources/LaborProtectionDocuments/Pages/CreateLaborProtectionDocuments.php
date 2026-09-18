<?php

namespace App\Filament\Resources\LaborProtectionDocuments\Pages;

use App\Filament\Resources\LaborProtectionDocuments\LaborProtectionDocumentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLaborProtectionDocuments extends CreateRecord
{
    protected static string $resource = LaborProtectionDocumentsResource::class;

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
            
            $fieldsToUnset = [
                'title_ru', 'title_kk', 'title_en',
                'description_ru', 'description_kk', 'description_en'
            ];
            
            foreach ($fieldsToUnset as $field) {
                unset($data[$field]);
            }
        } else {
            if (empty($data['title'] ?? '')) {
                $data['title'] = 'Документ по охране труда';
            }
            if (empty($data['description'] ?? '')) {
                $data['description'] = '';
            }
        }
        
        return $data;
    }
}