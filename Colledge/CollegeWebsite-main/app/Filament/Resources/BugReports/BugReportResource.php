<?php

namespace App\Filament\Resources\BugReports;

use App\Filament\Resources\BugReports\Pages;
use App\Models\BugReport;
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

class BugReportResource extends Resource
{
    protected static ?string $model = BugReport::class;

    protected static ?string $navigationLabel = 'Ошибки на сайте';
    protected static ?string $modelLabel = 'Отчет об ошибке';
    protected static ?string $pluralModelLabel = 'Отчеты об ошибках';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-bug-ant';
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
            Section::make('Информация о пользователе')
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
                ])->columns(3),

            Section::make('Техническая информация')
                ->schema([
                    TextInput::make('page_url')
                        ->label('URL страницы')
                        ->url()
                        ->disabled()
                        ->columnSpan(2),

                    TextInput::make('browser')
                        ->label('Браузер')
                        ->disabled(),

                    TextInput::make('os')
                        ->label('Операционная система')
                        ->disabled(),

                    TextInput::make('device')
                        ->label('Устройство')
                        ->disabled(),
                ])->columns(3),

            Section::make('Информация об ошибке')
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок ошибки')
                        ->required()
                        ->maxLength(255)
                        ->disabled()
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Подробное описание')
                        ->required()
                        ->rows(4)
                        ->disabled()
                        ->columnSpanFull(),

                    Textarea::make('steps_to_reproduce')
                        ->label('Шаги для воспроизведения')
                        ->rows(3)
                        ->disabled()
                        ->columnSpan(2),

                    Textarea::make('expected_result')
                        ->label('Ожидаемый результат')
                        ->rows(3)
                        ->disabled()
                        ->columnSpan(2),

                    Textarea::make('actual_result')
                        ->label('Фактический результат')
                        ->rows(3)
                        ->disabled()
                        ->columnSpan(2),
                ])->columns(2),

            Section::make('Обработка отчета')
                ->schema([
                    Select::make('priority')
                        ->label('Приоритет')
                        ->options([
                            'critical' => 'Критический',
                            'high' => 'Высокий',
                            'medium' => 'Средний',
                            'low' => 'Низкий',
                        ])
                        ->required()
                        ->default('medium'),

                    Select::make('status')
                        ->label('Статус')
                        ->options([
                            'new' => 'Новое',
                            'in_progress' => 'В работе',
                            'resolved' => 'Решено',
                            'need_more_info' => 'Требует уточнений',
                            'cannot_reproduce' => 'Не воспроизводится',
                        ])
                        ->required()
                        ->default('new'),

                    Textarea::make('admin_comment')
                        ->label('Комментарий администратора')
                        ->rows(5)
                        ->placeholder('Опишите решение или задайте уточняющие вопросы')
                        ->columnSpanFull(),

                    DateTimePicker::make('resolved_at')
                        ->label('Дата решения')
                        ->default(now()),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50)
                    ->wrap()
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('ФИО')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Приоритет')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'critical' => 'Критический',
                        'high' => 'Высокий',
                        'medium' => 'Средний',
                        'low' => 'Низкий',
                        default => 'Не указан',
                    })
                    ->color(fn ($state) => match($state) {
                        'critical' => 'danger',
                        'high' => 'warning',
                        'medium' => 'info',
                        'low' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'new' => 'Новое',
                        'in_progress' => 'В работе',
                        'resolved' => 'Решено',
                        'need_more_info' => 'Требует уточнений',
                        'cannot_reproduce' => 'Не воспроизводится',
                        default => 'Неизвестно',
                    })
                    ->color(fn ($state) => match($state) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'need_more_info' => 'info',
                        'cannot_reproduce' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('page_url')
                    ->label('Страница')
                    ->limit(30)
                    ->tooltip(fn ($state) => $state)
                    ->toggleable(),

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
                        'resolved' => 'Решено',
                        'need_more_info' => 'Требует уточнений',
                        'cannot_reproduce' => 'Не воспроизводится',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->label('Приоритет')
                    ->options([
                        'critical' => 'Критический',
                        'high' => 'Высокий',
                        'medium' => 'Средний',
                        'low' => 'Низкий',
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

                BulkAction::make('mark_resolved')
                    ->label('Решено')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['status' => 'resolved', 'resolved_at' => now()])))
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('need_more_info')
                    ->label('Требует уточнений')
                    ->icon('heroicon-o-question-mark-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['status' => 'need_more_info'])))
                    ->deselectRecordsAfterCompletion()
                    ->color('info'),

                BulkAction::make('cannot_reproduce')
                    ->label('Не воспроизводится')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['status' => 'cannot_reproduce'])))
                    ->deselectRecordsAfterCompletion()
                    ->color('gray'),

                BulkAction::make('delete')
                    ->label('Удалить выбранные')
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
            'index' => Pages\ListBugReports::route('/'),
            'create' => Pages\CreateBugReport::route('/create'),
            'edit' => Pages\EditBugReport::route('/{record}/edit'),
        ];
    }
}