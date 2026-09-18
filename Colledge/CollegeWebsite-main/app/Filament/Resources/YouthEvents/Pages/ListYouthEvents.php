<?php

namespace App\Filament\Resources\YouthEvents\Pages;

use App\Filament\Resources\YouthEvents\YouthEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListYouthEvents extends ListRecords
{
    protected static string $resource = YouthEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
