<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChatSession extends EditRecord
{
    protected static string $resource = ChatSessionResource::class;
    
    protected static ?string $title = 'Чат';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}