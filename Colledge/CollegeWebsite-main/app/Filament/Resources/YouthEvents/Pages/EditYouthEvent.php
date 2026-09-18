<?php

namespace App\Filament\Resources\YouthEvents\Pages;

use App\Filament\Resources\YouthEvents\YouthEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditYouthEvent extends EditRecord
{
    protected static string $resource = YouthEventResource::class;

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
            $title = $record->getRawOriginal('title');
            $shortDescription = $record->getRawOriginal('short_description');
            $description = $record->getRawOriginal('description');
            $location = $record->getRawOriginal('location');
            $organizer = $record->getRawOriginal('organizer');
            
            $titleData = json_decode($title, true) ?? [];
            $shortDescriptionData = json_decode($shortDescription, true) ?? [];
            $descriptionData = json_decode($description, true) ?? [];
            $locationData = json_decode($location, true) ?? [];
            $organizerData = json_decode($organizer, true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['short_description_ru'] = $shortDescriptionData['ru'] ?? '';
            $data['short_description_kk'] = $shortDescriptionData['kk'] ?? '';
            $data['short_description_en'] = $shortDescriptionData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            if (is_string($location) && str_starts_with(trim($location), '{')) {
                $data['location_ru'] = $locationData['ru'] ?? '';
                $data['location_kk'] = $locationData['kk'] ?? '';
                $data['location_en'] = $locationData['en'] ?? '';
                $data['location'] = ''; 
            }
            
            if (is_string($organizer) && str_starts_with(trim($organizer), '{')) {
                $data['organizer_ru'] = $organizerData['ru'] ?? '';
                $data['organizer_kk'] = $organizerData['kk'] ?? '';
                $data['organizer_en'] = $organizerData['en'] ?? '';
                $data['organizer'] = ''; 
            }
            
            unset(
                $data['title'], $data['short_description'], $data['description']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateYouthEvent::processFormData($data);
    }
}