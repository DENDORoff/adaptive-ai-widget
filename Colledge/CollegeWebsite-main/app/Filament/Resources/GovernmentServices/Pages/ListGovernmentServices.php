<?php

namespace App\Filament\Resources\GovernmentServices\Pages;

use App\Filament\Resources\GovernmentServices\GovernmentServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGovernmentServices extends ListRecords
{
    protected static string $resource = GovernmentServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
