<?php

namespace App\Filament\Resources\UnionEducationDocuments\Pages;

use App\Filament\Resources\UnionEducationDocuments\UnionEducationDocumentsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnionEducationDocuments extends ListRecords
{
    protected static string $resource = UnionEducationDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
