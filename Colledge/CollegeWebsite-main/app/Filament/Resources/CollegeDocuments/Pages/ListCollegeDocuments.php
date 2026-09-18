<?php

namespace App\Filament\Resources\CollegeDocuments\Pages;

use App\Filament\Resources\CollegeDocuments\CollegeDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCollegeDocuments extends ListRecords
{
    protected static string $resource = CollegeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
