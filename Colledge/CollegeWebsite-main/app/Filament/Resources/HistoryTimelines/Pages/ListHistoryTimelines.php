<?php

namespace App\Filament\Resources\HistoryTimelines\Pages;

use App\Filament\Resources\HistoryTimelines\HistoryTimelineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHistoryTimelines extends ListRecords
{
    protected static string $resource = HistoryTimelineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
