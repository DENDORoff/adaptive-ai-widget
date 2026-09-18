<?php

namespace App\Filament\Resources\Appeals\Pages;

use App\Filament\Resources\Appeals\AppealResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppeal extends CreateRecord
{
    protected static string $resource = AppealResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}