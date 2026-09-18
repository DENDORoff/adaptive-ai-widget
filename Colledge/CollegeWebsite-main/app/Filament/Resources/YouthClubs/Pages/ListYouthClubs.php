<?php

namespace App\Filament\Resources\YouthClubs\Pages;

use App\Filament\Resources\YouthClubs\YouthClubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListYouthClubs extends ListRecords
{
    protected static string $resource = YouthClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
