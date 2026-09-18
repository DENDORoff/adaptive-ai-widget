<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\StaffResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaff extends EditRecord
{
    protected static string $resource = StaffResource::class;

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
            $multilangFields = [
                'full_name', 'position', 'bio', 'education', 'specialty',
                'diploma_specialty', 'diploma_qualification', 'teaching_subjects',
                'work_experience_total', 'work_experience_pedagogical',
                'category', 'awards', 'professional_development'
            ];
            
            foreach ($multilangFields as $field) {
                $rawValue = $record->getRawOriginal($field);
                $fieldData = json_decode($rawValue, true) ?? [];
                
                $data[$field . '_ru'] = $fieldData['ru'] ?? '';
                $data[$field . '_kk'] = $fieldData['kk'] ?? '';
                $data[$field . '_en'] = $fieldData['en'] ?? '';
                
                unset($data[$field]);
            }
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateStaff::processFormData($data);
    }
}