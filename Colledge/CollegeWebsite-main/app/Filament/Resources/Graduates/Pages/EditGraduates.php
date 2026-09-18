<?php

namespace App\Filament\Resources\Graduates\Pages;

use App\Filament\Resources\Graduates\GraduatesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGraduates extends EditRecord
{
    protected static string $resource = GraduatesResource::class;

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
            $name = $record->getRawOriginal('name');
            $specialty = $record->getRawOriginal('specialty');
            $position = $record->getRawOriginal('position');
            $story = $record->getRawOriginal('story');
            $company = $record->getRawOriginal('company');
            
            $nameData = json_decode($name, true) ?? [];
            $specialtyData = json_decode($specialty, true) ?? [];
            $positionData = json_decode($position, true) ?? [];
            $storyData = json_decode($story, true) ?? [];
            $companyData = json_decode($company, true) ?? [];
            
            $data['name_ru'] = $nameData['ru'] ?? '';
            $data['name_kk'] = $nameData['kk'] ?? '';
            $data['name_en'] = $nameData['en'] ?? '';
            
            $data['specialty_ru'] = $specialtyData['ru'] ?? '';
            $data['specialty_kk'] = $specialtyData['kk'] ?? '';
            $data['specialty_en'] = $specialtyData['en'] ?? '';
            
            $data['position_ru'] = $positionData['ru'] ?? '';
            $data['position_kk'] = $positionData['kk'] ?? '';
            $data['position_en'] = $positionData['en'] ?? '';
            
            $data['story_ru'] = $storyData['ru'] ?? '';
            $data['story_kk'] = $storyData['kk'] ?? '';
            $data['story_en'] = $storyData['en'] ?? '';
            
            if (is_string($company) && str_starts_with(trim($company), '{')) {
                $data['company_ru'] = $companyData['ru'] ?? '';
                $data['company_kk'] = $companyData['kk'] ?? '';
                $data['company_en'] = $companyData['en'] ?? '';
                $data['company'] = ''; 
            }
            
            unset(
                $data['name'], $data['specialty'], $data['position'],
                $data['story']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateGraduates::processFormData($data);
    }
}