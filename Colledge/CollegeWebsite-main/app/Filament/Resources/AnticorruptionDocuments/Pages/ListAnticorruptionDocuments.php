<?php

namespace App\Filament\Resources\AnticorruptionDocuments\Pages;

use App\Filament\Resources\AnticorruptionDocuments\AnticorruptionDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnticorruptionDocuments extends ListRecords
{
    protected static string $resource = AnticorruptionDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
