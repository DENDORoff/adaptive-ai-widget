<?php

namespace App\Filament\Resources\YouthAnnouncements\Pages;

use App\Filament\Resources\YouthAnnouncements\YouthAnnouncementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditYouthAnnouncement extends EditRecord
{
    protected static string $resource = YouthAnnouncementResource::class;

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
            $content = $record->getRawOriginal('content');
            $actionText = $record->getRawOriginal('action_text');
            
            $titleData = json_decode($title, true) ?? [];
            $contentData = json_decode($content, true) ?? [];
            $actionTextData = json_decode($actionText, true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['content_ru'] = $contentData['ru'] ?? '';
            $data['content_kk'] = $contentData['kk'] ?? '';
            $data['content_en'] = $contentData['en'] ?? '';
            
            if (is_string($actionText) && str_starts_with(trim($actionText), '{')) {
                $data['action_text_ru'] = $actionTextData['ru'] ?? '';
                $data['action_text_kk'] = $actionTextData['kk'] ?? '';
                $data['action_text_en'] = $actionTextData['en'] ?? '';
                $data['action_text'] = ''; // Очищаем оригинальное поле
            }
            
            unset($data['title'], $data['content']);
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateYouthAnnouncement::processFormData($data);
    }
}