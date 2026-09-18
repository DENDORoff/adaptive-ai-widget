<?php

namespace App\Filament\Resources\Vacancies\Pages;

use App\Filament\Resources\Vacancies\VacancyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVacancy extends EditRecord
{
    protected static string $resource = VacancyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        
        if ($record && $record->exists && $record->is_multilang) {
            $titleData = json_decode($record->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($record->getRawOriginal('description'), true) ?? [];
            $salaryData = json_decode($record->getRawOriginal('salary'), true) ?? [];
            $locationData = json_decode($record->getRawOriginal('location'), true) ?? [];
            $employmentTypeData = json_decode($record->getRawOriginal('employment_type'), true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            $data['salary_ru'] = $salaryData['ru'] ?? '';
            $data['salary_kk'] = $salaryData['kk'] ?? '';
            $data['salary_en'] = $salaryData['en'] ?? '';
            
            $data['location_ru'] = $locationData['ru'] ?? '';
            $data['location_kk'] = $locationData['kk'] ?? '';
            $data['location_en'] = $locationData['en'] ?? '';
            
            $data['employment_type_ru'] = $employmentTypeData['ru'] ?? '';
            $data['employment_type_kk'] = $employmentTypeData['kk'] ?? '';
            $data['employment_type_en'] = $employmentTypeData['en'] ?? '';
            
            unset(
                $data['title'], $data['description'], $data['salary'],
                $data['location'], $data['employment_type']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateVacancy::processFormData($data);
    }
}