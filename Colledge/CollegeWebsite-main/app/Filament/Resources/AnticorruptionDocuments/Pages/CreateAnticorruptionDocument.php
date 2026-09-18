<?php

namespace App\Filament\Resources\AnticorruptionDocuments\Pages;

use App\Filament\Resources\AnticorruptionDocuments\AnticorruptionDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAnticorruptionDocument extends CreateRecord
{
    protected static string $resource = AnticorruptionDocumentResource::class;

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
            

            unset(
                $data['title_ru'], 
                $data['title_kk'], 
                $data['title_en'],
                $data['description_ru'], 
                $data['description_kk'], 
                $data['description_en']
            );
        } else {

            if (empty($data['title'] ?? '')) {
                $data['title'] = 'Документ';
            }
            if (empty($data['description'] ?? '')) {
                $data['description'] = '';
            }
        }
        
        $originalSlug = $data['slug'] ?? '';
        $counter = 1;
        
        while (\App\Models\AnticorruptionDocument::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $data;
    }
}