<?php

namespace App\Filament\Resources\Councils\Pages;

use App\Filament\Resources\Councils\CouncilResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCouncil extends EditRecord
{
    protected static string $resource = CouncilResource::class;

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
            $chairman = $record->getRawOriginal('chairman');
            $meetingFrequency = $record->getRawOriginal('meeting_frequency');
            $workPeriod = $record->getRawOriginal('work_period');
            
            $titleData = json_decode($title, true) ?? [];
            $descriptionData = json_decode($description, true) ?? [];
            $chairmanData = json_decode($chairman, true) ?? [];
            $meetingFrequencyData = json_decode($meetingFrequency, true) ?? [];
            $workPeriodData = json_decode($workPeriod, true) ?? [];
            
            $data['title_ru'] = $titleData['ru'] ?? '';
            $data['title_kk'] = $titleData['kk'] ?? '';
            $data['title_en'] = $titleData['en'] ?? '';
            
            $data['description_ru'] = $descriptionData['ru'] ?? '';
            $data['description_kk'] = $descriptionData['kk'] ?? '';
            $data['description_en'] = $descriptionData['en'] ?? '';
            
            $data['chairman_ru'] = $chairmanData['ru'] ?? '';
            $data['chairman_kk'] = $chairmanData['kk'] ?? '';
            $data['chairman_en'] = $chairmanData['en'] ?? '';
            
            $data['meeting_frequency_ru'] = $meetingFrequencyData['ru'] ?? '';
            $data['meeting_frequency_kk'] = $meetingFrequencyData['kk'] ?? '';
            $data['meeting_frequency_en'] = $meetingFrequencyData['en'] ?? '';
            
            $data['work_period_ru'] = $workPeriodData['ru'] ?? '';
            $data['work_period_kk'] = $workPeriodData['kk'] ?? '';
            $data['work_period_en'] = $workPeriodData['en'] ?? '';
            
            unset(
                $data['title'], $data['description'], $data['chairman'],
                $data['meeting_frequency'], $data['work_period']
            );
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreateCouncil::processFormData($data);
    }
}