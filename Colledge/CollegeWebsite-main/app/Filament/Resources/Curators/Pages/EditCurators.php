<?php

namespace App\Filament\Resources\Curators\Pages;

use App\Filament\Resources\Curators\CuratorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCurators extends EditRecord
{
    protected static string $resource = CuratorResource::class;

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
                'curator_name', 'curator_position', 'group_name', 'specialty',
                'room_number', 'consultation_schedule', 'additional_info'
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
        return CreateCurators::processFormData($data);
    }
}