<?php

namespace App\Filament\Resources\YouthAnnouncements\Pages;

use App\Filament\Resources\YouthAnnouncements\YouthAnnouncementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListYouthAnnouncements extends ListRecords
{
    protected static string $resource = YouthAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
