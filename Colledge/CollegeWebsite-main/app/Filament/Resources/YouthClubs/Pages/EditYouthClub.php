<?php

namespace App\Filament\Resources\YouthClubs\Pages;

use App\Filament\Resources\YouthClubs\YouthClubResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditYouthClub extends EditRecord
{
    protected static string $resource = YouthClubResource::class;

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
            $shortDescription = $record->getRawOriginal('short_description');
            $description = $record->getRawOriginal('description');
            $schedule = $record->getRawOriginal('schedule');
            $location = $record->getRawOriginal('location');
            $room = $record->getRawOriginal('room');
            $instructorName = $record->getRawOriginal('instructor_name');
            
            $nameData = json_decode($name, true) ?? [];
            $shortDescriptionData = json_decode($shortDescription, true) ?? [];
            $descriptionData = json_decode($description, true) ?? [];
            $scheduleData = json_decode($schedule, true) ?? [];
            $locationData = json_decode($location, true) ?? [];
            $roomData = json_decode($room, true) ?? [];
            $instructorNameData = json_decode($instructorName, true) ?? [];
            
            $data['name_ru'] = $nameData['ru'] ?? '';
            $data['name_kk'] = $nameData['kk'] ?? '';
            $data['name_en'] = $nameData['en'] ?? '';
            
            $data['short_description_ru'] = $shortDescriptionData['ru'] ?? '';
            $data['short_description_kk'] = $shortDescriptionData['kk'] ?? '';
            $data['short_description_en'] = $shortDescriptionData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            $additionalFields = [
                'schedule' => $scheduleData,
                'location' => $locationData,
                'room' => $roomData,
                'instructor_name' => $instructorNameData,
            ];
            
            foreach ($additionalFields as $field => $fieldData) {
                $originalValue = $record->getRawOriginal($field);
                if (is_string($originalValue) && str_starts_with(trim($originalValue), '{')) {
                    $data[$field . '_ru'] = $fieldData['ru'] ?? '';
                    $data[$field . '_kk'] = $fieldData['kk'] ?? '';
                    $data[$field . '_en'] = $fieldData['en'] ?? '';
                    $data[$field] = ''; 
                }
            }
            
            unset(
                $data['name'], $data['short_description'], $data['description']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateYouthClub::processFormData($data);
    }
}