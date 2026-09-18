<?php

namespace App\Filament\Resources\ChatSessions;

use App\Filament\Resources\ChatSessions\Pages;
use App\Filament\Resources\ChatSessions\Tables\ChatSessionsTable;
use App\Models\ChatSession;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ChatSessionResource extends Resource
{
    protected static ?string $model = ChatSession::class;

    protected static ?string $navigationLabel = 'Чат-поддержка';
    protected static ?string $modelLabel = 'Чат';
    protected static ?string $pluralModelLabel = 'Чаты';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-chat-bubble-bottom-center-text';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::active()->hasUnread()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function table(Table $table): Table
    {
        return ChatSessionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatSessions::route('/'),
            'view' => Pages\ViewChatSession::route('/{record}'),
        ];
    }
}