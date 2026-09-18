<?php

namespace App\Filament\Resources\Vacancies\Pages;

use App\Filament\Resources\Vacancies\VacancyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVacancy extends CreateRecord
{
    protected static string $resource = VacancyResource::class;

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
            
            $data['salary'] = json_encode([
                'ru' => $data['salary_ru'] ?? '',
                'kk' => $data['salary_kk'] ?? '',
                'en' => $data['salary_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['location'] = json_encode([
                'ru' => $data['location_ru'] ?? '',
                'kk' => $data['location_kk'] ?? '',
                'en' => $data['location_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['employment_type'] = json_encode([
                'ru' => $data['employment_type_ru'] ?? '',
                'kk' => $data['employment_type_kk'] ?? '',
                'en' => $data['employment_type_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            unset(
                $data['title_ru'], $data['title_kk'], $data['title_en'],
                $data['description_ru'], $data['description_kk'], $data['description_en'],
                $data['salary_ru'], $data['salary_kk'], $data['salary_en'],
                $data['location_ru'], $data['location_kk'], $data['location_en'],
                $data['employment_type_ru'], $data['employment_type_kk'], $data['employment_type_en']
            );
        } else {
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Вакансия';
            }
            if (!isset($data['description']) || empty($data['description'])) {
                $data['description'] = '';
            }
            if (!isset($data['salary']) || empty($data['salary'])) {
                $data['salary'] = '';
            }
            if (!isset($data['location']) || empty($data['location'])) {
                $data['location'] = '';
            }
            if (!isset($data['employment_type']) || empty($data['employment_type'])) {
                $data['employment_type'] = '';
            }
        }
        
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title'] ?? 'vacancy');
        }
        
        return $data;
    }
}