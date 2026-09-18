<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use Filament\Resources\Pages\ListRecords;

class ListChatSessions extends ListRecords
{
    protected static string $resource = ChatSessionResource::class;
    
    protected static ?string $title = 'Чат-поддержка';

    protected function getHeaderActions(): array
    {
        return [];
    }
    
    // Автообновление каждые 10 секунд
    public function getRefreshInterval(): ?string
    {
        return '10s';
    }
}