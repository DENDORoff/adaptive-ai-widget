<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\StaffResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return self::processFormData($data);
    }

    public static function processFormData(array $data): array
    {
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $multilangFields = [
                'full_name' => ['ru', 'kk', 'en'],
                'position' => ['ru', 'kk', 'en'],
                'bio' => ['ru', 'kk', 'en'],
                'education' => ['ru', 'kk', 'en'],
                'specialty' => ['ru', 'kk', 'en'],
                'diploma_specialty' => ['ru', 'kk', 'en'],
                'diploma_qualification' => ['ru', 'kk', 'en'],
                'teaching_subjects' => ['ru', 'kk', 'en'],
                'work_experience_total' => ['ru', 'kk', 'en'],
                'work_experience_pedagogical' => ['ru', 'kk', 'en'],
                'category' => ['ru', 'kk', 'en'],
                'awards' => ['ru', 'kk', 'en'],
                'professional_development' => ['ru', 'kk', 'en'],
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