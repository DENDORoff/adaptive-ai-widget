<?php

namespace App\Filament\Resources\GovernmentServices\Pages;

use App\Filament\Resources\GovernmentServices\GovernmentServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGovernmentService extends CreateRecord
{
    protected static string $resource = GovernmentServiceResource::class;

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
            
            $data['execution_time'] = json_encode([
                'ru' => $data['execution_time_ru'] ?? '',
                'kk' => $data['execution_time_kk'] ?? '',
                'en' => $data['execution_time_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['responsible_department'] = json_encode([
                'ru' => $data['responsible_department_ru'] ?? '',
                'kk' => $data['responsible_department_kk'] ?? '',
                'en' => $data['responsible_department_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['required_documents'] = json_encode([
                'ru' => $data['required_documents_ru'] ?? '',
                'kk' => $data['required_documents_kk'] ?? '',
                'en' => $data['required_documents_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            unset(
                $data['title_ru'], $data['title_kk'], $data['title_en'],
                $data['description_ru'], $data['description_kk'], $data['description_en'],
                $data['execution_time_ru'], $data['execution_time_kk'], $data['execution_time_en'],
                $data['responsible_department_ru'], $data['responsible_department_kk'], $data['responsible_department_en'],
                $data['required_documents_ru'], $data['required_documents_kk'], $data['required_documents_en']
            );
        } else {
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Государственная услуга';
            }
            if (!isset($data['description']) || empty($data['description'])) {
                $data['description'] = '';
            }
            if (!isset($data['execution_time']) || empty($data['execution_time'])) {
                $data['execution_time'] = '15 рабочих дней';
            }
            if (!isset($data['responsible_department']) || empty($data['responsible_department'])) {
                $data['responsible_department'] = 'Деканат / Приемная комиссия';
            }
            if (!isset($data['required_documents']) || empty($data['required_documents'])) {
                $data['required_documents'] = '';
            }
        }
        
        return $data;
    }
}