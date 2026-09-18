<?php

namespace App\Filament\Resources\Curators\Pages;

use App\Filament\Resources\Curators\CuratorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCurators extends CreateRecord
{
    protected static string $resource = CuratorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return self::processFormData($data);
    }

    public static function processFormData(array $data): array
    {
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $multilangFields = [
                'curator_name' => ['ru', 'kk', 'en'],
                'curator_position' => ['ru', 'kk', 'en'],
                'group_name' => ['ru', 'kk', 'en'],
                'specialty' => ['ru', 'kk', 'en'],
                'room_number' => ['ru', 'kk', 'en'],
                'consultation_schedule' => ['ru', 'kk', 'en'],
                'additional_info' => ['ru', 'kk', 'en'],
            ];
            
            foreach ($multilangFields as $field => $languages) {
                $jsonData = [];
                foreach ($languages as $lang) {
                    $key = $field . '_' . $lang;
                    $jsonData[$lang] = $data[$key] ?? '';
                    unset($data[$key]);
                }
                $data[$field] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);
            }
        }
        
        return $data;
    }
}