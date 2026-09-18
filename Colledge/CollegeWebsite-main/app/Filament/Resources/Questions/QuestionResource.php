<?php

namespace App\Filament\Resources\Questions;

use App\Filament\Resources\Questions\Pages;
use App\Models\Question;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationLabel = 'Вопросы';
    protected static ?string $modelLabel = 'Вопрос';
    protected static ?string $pluralModelLabel = 'Вопросы';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-chat-bubble-left-right';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Информация о вопросе')
                ->schema([
                    TextInput::make('name')
                        ->label('Имя отправителя')
                        ->required()
                        ->maxLength(255)
                        ->disabled(),
                    
                    TextInput::make('email')
                        ->label('Email отправителя')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->disabled(),
                    
                    Textarea::make('question')
                        ->label('Вопрос')
                        ->required()
                        ->rows(4)
                        ->disabled()
                        ->columnSpanFull(),
                ])->columns(2),
            
            Section::make('Ответ')
                ->schema([
                    RichEditor::make('answer')
                        ->label('Ответ руководителя')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'link',
                            'bulletList',
                            'orderedList',
                        ]),
                    
                    Toggle::make('is_answered')
                        ->label('Отвечен')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $set('is_published', false);
                            }
                        }),
                    
                    Toggle::make('is_published')
                        ->label('Опубликовать на сайте')
                        ->helperText('Вопрос и ответ будут видны всем посетителям'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email скопирован!'),
                
                Tables\Columns\TextColumn::make('question')
                    ->label('Вопрос')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                
                Tables\Columns\IconColumn::make('is_answered')
                    ->label('Отвечен')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликован')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Получен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_answered')
                    ->label('Отвечен')
                    ->placeholder('Все вопросы')
                    ->trueLabel('Отвеченные')
                    ->falseLabel('Неотвеченные'),
                
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликован'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('delete')
                    ->label('Удалить выбранные')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): string|null
    {
        return static::getModel()::where('is_answered', false)->count() ?: null;
    }
    
    public static function getNavigationBadgeColor(): string|null
    {
        return 'warning';
    }
}