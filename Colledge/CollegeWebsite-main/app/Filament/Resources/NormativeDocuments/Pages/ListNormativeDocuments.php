<?php

namespace App\Filament\Resources\NormativeDocuments\Pages;

use App\Filament\Resources\NormativeDocuments\NormativeDocumentsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNormativeDocuments extends ListRecords
{
    protected static string $resource = NormativeDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
