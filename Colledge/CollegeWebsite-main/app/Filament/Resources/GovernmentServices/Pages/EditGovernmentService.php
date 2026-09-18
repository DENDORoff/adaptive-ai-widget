<?php

namespace App\Filament\Resources\GovernmentServices\Pages;

use App\Filament\Resources\GovernmentServices\GovernmentServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGovernmentService extends EditRecord
{
    protected static string $resource = GovernmentServiceResource::class;

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
            $executionTime = $record->getRawOriginal('execution_time');
            $department = $record->getRawOriginal('responsible_department');
            $documents = $record->getRawOriginal('required_documents');
            
            $titleData = json_decode($title, true) ?? [];
            $descriptionData = json_decode($description, true) ?? [];
            $executionTimeData = json_decode($executionTime, true) ?? [];
            $departmentData = json_decode($department, true) ?? [];
            $documentsData = json_decode($documents, true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            $data['execution_time_ru'] = $executionTimeData['ru'] ?? '';
            $data['execution_time_kk'] = $executionTimeData['kk'] ?? '';
            $data['execution_time_en'] = $executionTimeData['en'] ?? '';
            
            $data['responsible_department_ru'] = $departmentData['ru'] ?? '';
            $data['responsible_department_kk'] = $departmentData['kk'] ?? '';
            $data['responsible_department_en'] = $departmentData['en'] ?? '';
            
            $data['required_documents_ru'] = $documentsData['ru'] ?? '';
            $data['required_documents_kk'] = $documentsData['kk'] ?? '';
            $data['required_documents_en'] = $documentsData['en'] ?? '';
            
            unset(
                $data['title'], $data['description'], $data['execution_time'],
                $data['responsible_department'], $data['required_documents']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateGovernmentService::processFormData($data);
    }
}