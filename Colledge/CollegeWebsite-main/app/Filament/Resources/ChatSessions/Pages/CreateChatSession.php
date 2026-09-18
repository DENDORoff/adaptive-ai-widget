<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatSession extends CreateRecord
{
    protected static string $resource = ChatSessionResource::class;
}
