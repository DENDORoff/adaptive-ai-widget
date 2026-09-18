<?php

namespace App\Filament\Resources\Appeals\Pages;

use App\Filament\Resources\Appeals\AppealResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppeals extends ListRecords
{
    protected static string $resource = AppealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
