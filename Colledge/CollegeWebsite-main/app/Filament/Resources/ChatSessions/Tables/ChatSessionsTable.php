<?php

namespace App\Filament\Resources\ChatSessions\Tables;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('session_id')
                    ->label('ID')
                    ->searchable()
                    ->limit(15)
                    ->tooltip(fn ($record) => $record->session_id),
                    
                \Filament\Tables\Columns\TextColumn::make('user_name')
                    ->label('Имя')
                    ->searchable()
                    ->default('Гость')
                    ->weight('bold'),
                    
                \Filament\Tables\Columns\TextColumn::make('user_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                    
                \Filament\Tables\Columns\TextColumn::make('unread_count')
                    ->label('Непрочитано')
                    ->getStateUsing(function ($record) {
                        return $record->unreadMessages()->count();
                    })
                    ->badge()
                    ->color('warning')
                    ->visible(fn ($state) => $state > 0),
                    
                \Filament\Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'closed',
                    ])
                    ->formatStateUsing(fn (string $state): string => 
                        $state === 'active' ? 'Активный' : 'Закрыт'
                    ),
                    
                \Filament\Tables\Columns\TextColumn::make('messages_count')
                    ->label('Сообщений')
                    ->counts('messages')
                    ->badge()
                    ->color('info'),
                    
                \Filament\Tables\Columns\TextColumn::make('last_message_at')
                    ->label('Последнее сообщение')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                    
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_message_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'active' => 'Активные',
                        'closed' => 'Закрытые',
                    ]),
                    
                \Filament\Tables\Filters\Filter::make('unread')
                    ->label('С непрочитанными')
                    ->query(fn (Builder $query): Builder => $query->hasUnread()),
            ])
            ->recordActions([
                // Действие для просмотра чата
                Action::make('view')
                    ->label('Открыть чат')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('primary')
                    ->url(fn ($record) => ChatSessionResource::getUrl('view', ['record' => $record])),
                    
                // Действие для закрытия чата
                Action::make('close')
                    ->label('Закрыть')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Закрыть чат')
                    ->modalDescription('Вы уверены, что хотите закрыть этот чат?')
                    ->action(function ($record) {
                        $record->update(['status' => 'closed']);
                        
                        Notification::make()
                            ->success()
                            ->title('Чат закрыт')
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'active'),
                    
                // Действие для открытия чата
                Action::make('reopen')
                    ->label('Открыть')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['status' => 'active']);
                        
                        Notification::make()
                            ->success()
                            ->title('Чат открыт')
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'closed'),
                    
                // Удаление чата
                DeleteAction::make()
                    ->label('Удалить')
                    ->requiresConfirmation()
                    ->modalHeading('Удалить чат')
                    ->modalDescription('Чат будет удален как у администратора, так и у пользователя.')
                    ->after(function ($record) {
                        // Удаляем все сообщения
                        $record->messages()->delete();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Массовое действие для отметки прочитанными
                    \Filament\Actions\BulkAction::make('mark_read')
                        ->label('Отметить прочитанными')
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->messages()
                                    ->where('is_admin', false)
                                    ->where('is_read', false)
                                    ->update(['is_read' => true]);
                            }
                            
                            Notification::make()
                                ->success()
                                ->title('Сообщения отмечены как прочитанные')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('success'),
                        
                    // Массовое действие для закрытия чатов
                    \Filament\Actions\BulkAction::make('close_selected')
                        ->label('Закрыть выбранные')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['status' => 'closed']);
                            
                            Notification::make()
                                ->success()
                                ->title('Чаты закрыты')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('danger'),
                        
                    // Массовое удаление
                    DeleteBulkAction::make()
                        ->label('Удалить выбранные')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Удалить чаты')
                        ->modalDescription('Чаты будут удалены как у администратора, так и у пользователей.')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->messages()->delete();
                                $record->delete();
                            }
                            
                            Notification::make()
                                ->success()
                                ->title('Чаты удалены')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            // Показываем только сессии с сообщениями
            ->modifyQueryUsing(function (Builder $query) {
                return $query->has('messages')->orderBy('last_message_at', 'desc');
            });
    }
}