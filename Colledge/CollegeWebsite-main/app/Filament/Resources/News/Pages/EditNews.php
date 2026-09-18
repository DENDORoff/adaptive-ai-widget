<?php

namespace App\Filament\Resources\News\Pages;

use App\Filament\Resources\News\NewsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

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
            \Log::info('=== mutateFormDataBeforeFill called ===');
            \Log::info('Record title from DB:', [$record->title]);
            
            $titleData = is_array($record->title) ? $record->title : json_decode($record->title, true);
            $excerptData = is_array($record->excerpt) ? $record->excerpt : json_decode($record->excerpt, true);
            $contentData = is_array($record->content) ? $record->content : json_decode($record->content, true);
            
            \Log::info('Title data decoded:', $titleData ?? []);
            
            $data['title_ru'] = is_array($titleData) ? ($titleData['ru'] ?? '') : '';
            $data['title_kk'] = is_array($titleData) ? ($titleData['kk'] ?? '') : '';
            $data['title_en'] = is_array($titleData) ? ($titleData['en'] ?? '') : '';
            
            $data['excerpt_ru'] = is_array($excerptData) ? ($excerptData['ru'] ?? '') : '';
            $data['excerpt_kk'] = is_array($excerptData) ? ($excerptData['kk'] ?? '') : '';
            $data['excerpt_en'] = is_array($excerptData) ? ($excerptData['en'] ?? '') : '';
            
            $data['content_ru'] = is_array($contentData) ? ($contentData['ru'] ?? '') : '';
            $data['content_kk'] = is_array($contentData) ? ($contentData['kk'] ?? '') : '';
            $data['content_en'] = is_array($contentData) ? ($contentData['en'] ?? '') : '';
            
            \Log::info('Filled data:', [
                'title_ru' => $data['title_ru'],
                'title_kk' => $data['title_kk'],
                'title_en' => $data['title_en'],
            ]);
            
            // НЕ удаляем старые поля - они нужны для обратной совместимости
            // unset($data['title'], $data['excerpt'], $data['content']);
        } else {
            \Log::info('Not multilingual or record doesnt exist');
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        \Log::info('=== mutateFormDataBeforeSave called ===');
        \Log::info('Data before save:', $data);
        
        $isMultilang = $data['is_multilang'] ?? false;
        
        if ($isMultilang) {
            $data['title'] = json_encode([
                'ru' => $data['title_ru'] ?? '',
                'kk' => $data['title_kk'] ?? '',
                'en' => $data['title_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['excerpt'] = json_encode([
                'ru' => $data['excerpt_ru'] ?? '',
                'kk' => $data['excerpt_kk'] ?? '',
                'en' => $data['excerpt_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            $data['content'] = json_encode([
                'ru' => $data['content_ru'] ?? '',
                'kk' => $data['content_kk'] ?? '',
                'en' => $data['content_en'] ?? '',
            ], JSON_UNESCAPED_UNICODE);
            
            \Log::info('JSON created:', [
                'title' => $data['title'],
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
            ]);
            
            // НЕ удаляем временные поля формы - они нужны для повторного заполнения формы
            // unset(
            //     $data['title_ru'], $data['title_kk'], $data['title_en'],
            //     $data['excerpt_ru'], $data['excerpt_kk'], $data['excerpt_en'],
            //     $data['content_ru'], $data['content_kk'], $data['content_en']
            // );
        } else {
            if (!isset($data['title']) || empty($data['title'])) {
                $data['title'] = 'Без заголовка';
            }
        }
        
        return $data;
    }
    
    protected function fillForm(): void
    {
        \Log::info('=== fillForm called ===');
        
        $data = $this->mutateFormDataBeforeFill(
            $this->getRecord()->attributesToArray()
        );
        
        \Log::info('Data to fill form:', $data);
        
        $this->callHook('beforeFill');
        
        $this->form->fill($data);
        
        $this->callHook('afterFill');
    }
}