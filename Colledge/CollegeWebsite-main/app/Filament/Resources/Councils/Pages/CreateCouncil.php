<?php

namespace App\Filament\Resources\Councils\Pages;

use App\Filament\Resources\Councils\CouncilResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCouncil extends CreateRecord
{
    protected static string $resource = CouncilResource::class;

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
            
            $data['chairman'] = json_encode([
                'ru' => $data['chairman_ru'] ?? '',
                'kk' => $data['chairman_kk'] ?? '',
                'en' => $data['chairman_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['meeting_frequency'] = json_encode([
                'ru' => $data['meeting_frequency_ru'] ?? '',
                'kk' => $data['meeting_frequency_kk'] ?? '',
                'en' => $data['meeting_frequency_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['work_period'] = json_encode([
                'ru' => $data['work_period_ru'] ?? '',
                'kk' => $data['work_period_kk'] ?? '',
                'en' => $data['work_period_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            unset(
                $data['title_ru'], $data['title_kk'], $data['title_en'],
                $data['description_ru'], $data['description_kk'], $data['description_en'],
                $data['chairman_ru'], $data['chairman_kk'], $data['chairman_en'],
                $data['meeting_frequency_ru'], $data['meeting_frequency_kk'], $data['meeting_frequency_en'],
                $data['work_period_ru'], $data['work_period_kk'], $data['work_period_en']
            );
        } else {
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Совет при колледже';
            }
            if (!isset($data['description']) || empty($data['description'])) {
                $data['description'] = '';
            }
            if (!isset($data['chairman']) || empty($data['chairman'])) {
                $data['chairman'] = '';
            }
            if (!isset($data['meeting_frequency']) || empty($data['meeting_frequency'])) {
                $data['meeting_frequency'] = '1 раз в месяц';
            }
            if (!isset($data['work_period']) || empty($data['work_period'])) {
                $data['work_period'] = '2023-2024 учебный год';
            }
        }
        
        if (!isset($data['icon']) || empty($data['icon'])) {
            $data['icon'] = 'fas fa-users';
        }
        
        if (!isset($data['order']) || empty($data['order'])) {
            $data['order'] = 0;
        }
        
        if (!isset($data['is_active'])) {
            $data['is_active'] = true;
        }
        
        return $data;
    }
}