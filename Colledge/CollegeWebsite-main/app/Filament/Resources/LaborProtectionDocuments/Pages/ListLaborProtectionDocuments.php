<?php

namespace App\Filament\Resources\LaborProtectionDocuments\Pages;

use App\Filament\Resources\LaborProtectionDocuments\LaborProtectionDocumentsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaborProtectionDocuments extends ListRecords
{
    protected static string $resource = LaborProtectionDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
