<?php

namespace App\Filament\Resources\ChatSessions\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class ChatSessionForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Информация о пользователе')
                ->schema([
                    TextInput::make('session_id')
                        ->label('ID сессии')
                        ->disabled(),
                        
                    TextInput::make('user_name')
                        ->label('Имя пользователя')
                        ->maxLength(255),
                        
                    TextInput::make('user_email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                        
                    Select::make('status')
                        ->label('Статус')
                        ->options([
                            'active' => 'Активный',
                            'closed' => 'Закрыт',
                        ])
                        ->default('active')
                        ->required(),
                ])->columns(2),

            Section::make('История переписки')
                ->schema([
                    Placeholder::make('messages_list')
                        ->label('')
                        ->content(function ($record) {
                            if (!$record) return 'Нет сообщений';
                            
                            $messages = $record->messages()->orderBy('created_at')->get();
                            
                            if ($messages->isEmpty()) {
                                return 'Нет сообщений';
                            }
                            
                            $html = '<div style="max-height: 500px; overflow-y: auto; padding: 10px; background: #f9fafb; border-radius: 8px;">';
                            
                            foreach ($messages as $message) {
                                $isAdmin = $message->is_admin;
                                $bgColor = $isAdmin ? '#dbeafe' : '#f3f4f6';
                                $align = $isAdmin ? 'margin-left: auto;' : 'margin-right: auto;';
                                $textAlign = $isAdmin ? 'text-align: right;' : 'text-align: left;';
                                $author = $isAdmin ? 'Администратор' : ($message->user_name ?? 'Пользователь');
                                
                                $html .= "<div style='max-width: 75%; {$align} padding: 12px 16px; border-radius: 12px; background: {$bgColor}; margin-bottom: 16px;'>";
                                $html .= "<div style='font-size: 11px; color: #6b7280; font-weight: 600; margin-bottom: 6px; {$textAlign}'>{$author}</div>";
                                $html .= "<div style='font-size: 14px; line-height: 1.5; color: #111827;'>" . nl2br(e($message->message)) . "</div>";
                                $html .= "<div style='font-size: 11px; color: #9ca3af; margin-top: 6px; {$textAlign}'>{$message->created_at->format('d.m.Y H:i')}</div>";
                                $html .= "</div>";
                            }
                            
                            $html .= '</div>';
                            
                            return new \Illuminate\Support\HtmlString($html);
                        }),
                ]),

            Section::make('Ответить')
                ->schema([
                    Textarea::make('admin_reply')
                        ->label('Ваш ответ')
                        ->rows(5)
                        ->placeholder('Введите ответ пользователю...')
                        ->helperText('После сохранения ответ будет отправлен пользователю')
                        ->columnSpanFull(),
                ])
                ->hidden(fn ($record) => !$record || $record->status === 'closed'),
        ]);
    }
}