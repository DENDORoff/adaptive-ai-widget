<?php

namespace App\Filament\Resources\Achievements\Pages;

use App\Filament\Resources\Achievements\AchievementsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAchievements extends EditRecord
{
    protected static string $resource = AchievementsResource::class;

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
            $description = $record->getRawOriginal('description');
            
            $titleData = json_decode($title, true) ?? [];
            $descriptionData = json_decode($description, true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            unset($data['title'], $data['description']);
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateAchievements::processFormData($data);
    }
}