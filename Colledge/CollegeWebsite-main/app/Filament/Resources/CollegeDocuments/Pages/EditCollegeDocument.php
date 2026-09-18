<?php

namespace App\Filament\Resources\CollegeDocuments\Pages;

use App\Filament\Resources\CollegeDocuments\CollegeDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCollegeDocument extends EditRecord
{
    protected static string $resource = CollegeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
