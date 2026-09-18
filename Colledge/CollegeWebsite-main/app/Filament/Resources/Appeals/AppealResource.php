<?php

namespace App\Filament\Resources\Appeals;

use App\Filament\Resources\Appeals\Pages;
use App\Models\Appeal;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class AppealResource extends Resource
{
    protected static ?string $model = Appeal::class;

    protected static ?string $navigationLabel = 'Обращения';
    protected static ?string $modelLabel = 'Обращение';
    protected static ?string $pluralModelLabel = 'Обращения';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-envelope';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Информация об обращении')
                ->schema([
                    TextInput::make('full_name')
                        ->label('ФИО')
                        ->required()
                        ->maxLength(255)
                        ->disabled(),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->disabled(),

                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->maxLength(255)
                        ->disabled(),

                    TextInput::make('category')
                        ->label('Категория')
                        ->required()
                        ->disabled(),

                    TextInput::make('subject')
                        ->label('Тема')
                        ->required()
                        ->disabled()
                        ->columnSpanFull(),

                    Textarea::make('message')
                        ->label('Сообщение')
                        ->required()
                        ->rows(5)
                        ->disabled()
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Обработка обращения')
                ->schema([
                    Select::make('status')
                        ->label('Статус')
                        ->options([
                            'new' => 'Новое',
                            'in_progress' => 'В работе',
                            'completed' => 'Завершено',
                        ])
                        ->required()
                        ->default('new'),

                    Textarea::make('admin_response')
                        ->label('Ответ администратора')
                        ->rows(5)
                        ->columnSpanFull(),

                    DateTimePicker::make('responded_at')
                        ->label('Дата ответа')
                        ->default(now()),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('ФИО')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->searchable()
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'Общий вопрос' => 'info',
                        'Жалоба' => 'danger',
                        'Предложение' => 'success',
                        'Техническая поддержка' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Тема')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'new' => 'Новое',
                        'in_progress' => 'В работе',
                        'completed' => 'Завершено',
                        default => 'Неизвестно',
                    })
                    ->color(fn ($state) => match($state) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новое',
                        'in_progress' => 'В работе',
                        'completed' => 'Завершено',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options([
                        'Общий вопрос' => 'Общий вопрос',
                        'Жалоба' => 'Жалоба',
                        'Предложение' => 'Предложение',
                        'Техническая поддержка' => 'Техническая поддержка',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('mark_in_progress')
                    ->label('В работу')
                    ->icon('heroicon-o-clock')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['status' => 'in_progress'])))
                    ->deselectRecordsAfterCompletion()
                    ->color('warning'),

                BulkAction::make('mark_completed')
                    ->label('Завершить')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['status' => 'completed', 'responded_at' => now()])))
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('delete')
                    ->label('Удалить выбранных')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->color('danger'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppeals::route('/'),
            'create' => Pages\CreateAppeal::route('/create'),
            'edit' => Pages\EditAppeal::route('/{record}/edit'),
            'view' => Pages\ViewAppeal::route('/{record}'),
        ];
    }
}