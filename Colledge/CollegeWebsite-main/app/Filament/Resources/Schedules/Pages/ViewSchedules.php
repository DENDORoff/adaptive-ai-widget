<?php

namespace App\Filament\Resources\Schedules\Pages;

use App\Filament\Resources\Schedules\SchedulesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSchedules extends ViewRecord
{
    protected static string $resource = SchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
