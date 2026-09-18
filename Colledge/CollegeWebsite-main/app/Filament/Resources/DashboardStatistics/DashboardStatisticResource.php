<?php

namespace App\Filament\Resources\DashboardStatistics;

use App\Filament\Resources\DashboardStatistics\Pages;
use App\Models\DashboardStatistic;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class DashboardStatisticResource extends Resource
{
    protected static ?string $model = DashboardStatistic::class;

    protected static ?string $navigationLabel = 'Статистика дашборда';
    protected static ?string $modelLabel = 'Статистика';
    protected static ?string $pluralModelLabel = 'Статистика дашборда';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Ситуационный центр';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('category')
                    ->label('Категория')
                    ->options(DashboardStatistic::getCategories())
                    ->required()
                    ->native(false),

                \Filament\Forms\Components\TextInput::make('key')
                    ->label('Ключ (уникальный идентификатор)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Должен совпадать с data-stat-key в фронтенде'),

                \Filament\Forms\Components\TextInput::make('label')
                    ->label('Название')
                    ->maxLength(255),

                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->rows(2),

                \Filament\Forms\Components\TextInput::make('value')
                    ->label('Текущее значение')
                    ->required()
                    ->helperText('Формат: число или строка'),

                \Filament\Forms\Components\TextInput::make('order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0),

                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Активна')
                    ->default(true),

                \Filament\Forms\Components\Toggle::make('auto_calculate_growth')
                    ->label('Считать рост автоматически')
                    ->live()
                    ->helperText('При включении будет рассчитываться рост относительно предыдущего значения'),

                \Filament\Forms\Components\TextInput::make('previous_value')
                    ->label('Предыдущее значение')
                    ->numeric()
                    ->disabled(fn ($get) => !$get('auto_calculate_growth'))
                    ->helperText('Укажите предыдущее значение для расчёта роста'),

                \Filament\Forms\Components\TextInput::make('growth_percentage')
                    ->label('Процент роста')
                    ->numeric()
                    ->suffix('%')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Рассчитывается автоматически'),

                \Filament\Forms\Components\Toggle::make('is_auto_updated')
                    ->label('Автообновление данных')
                    ->live()
                    ->helperText('Данные будут обновляться автоматически по расписанию'),

                \Filament\Forms\Components\Select::make('update_source')
                    ->label('Источник обновления')
                    ->options(DashboardStatistic::getUpdateSources())
                    ->native(false)
                    ->disabled(fn ($get) => !$get('is_auto_updated'))
                    ->helperText('Источник данных для автоматического обновления'),

                \Filament\Forms\Components\TextInput::make('unit')
                    ->label('Единица измерения')
                    ->maxLength(50)
                    ->helperText('Например: чел., %, млн ₸, TB и т.д.'),

                \Filament\Forms\Components\Select::make('data_type')
                    ->label('Тип данных')
                    ->options([
                        'number' => 'Число',
                        'percentage' => 'Процент',
                        'currency' => 'Валюта',
                        'text' => 'Текст',
                    ])
                    ->default('number')
                    ->native(false),

                \Filament\Forms\Components\Toggle::make('show_growth')
                    ->label('Показывать рост')
                    ->default(true),

                \Filament\Forms\Components\Toggle::make('is_public')
                    ->label('Публичный доступ')
                    ->default(true)
                    ->helperText('Доступно через API'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => 
                        DashboardStatistic::getCategories()[$state] ?? $state
                    )
                    ->colors([
                        'academic' => 'info',
                        'events' => 'success',
                        'services' => 'warning',
                        'tech' => 'danger',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Ключ скопирован')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('label')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('value')
                    ->label('Значение')
                    ->searchable()
                    ->description(fn (DashboardStatistic $record): string => 
                        $record->unit ? "{$record->value} {$record->unit}" : $record->value
                    ),

                Tables\Columns\TextColumn::make('growth_percentage')
                    ->label('Рост')
                    ->formatStateUsing(fn ($state): string => 
                        $state ? sprintf('%+.1f%%', $state) : '—'
                    )
                    ->color(fn ($state): string => 
                        $state > 0 ? 'success' : ($state < 0 ? 'danger' : 'gray')
                    )
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_auto_updated')
                    ->label('Автообн.')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options(DashboardStatistic::getCategories()),

                Tables\Filters\SelectFilter::make('data_type')
                    ->label('Тип данных')
                    ->options([
                        'number' => 'Число',
                        'percentage' => 'Процент',
                        'currency' => 'Валюта',
                        'text' => 'Текст',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активность'),

                Tables\Filters\TernaryFilter::make('is_auto_updated')
                    ->label('Автообновление'),
            ])
            ->actions([
                // В Filament v4 действия в пространстве имен Filament\Actions\
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),

                \Filament\Actions\BulkAction::make('activate')
                    ->label('Активировать')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_active' => true])
                    )
                    ->deselectRecordsAfterCompletion(),

                \Filament\Actions\BulkAction::make('deactivate')
                    ->label('Деактивировать')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_active' => false])
                    )
                    ->deselectRecordsAfterCompletion(),
            ])
            ->reorderable('order')
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDashboardStatistics::route('/'),
            'create' => Pages\CreateDashboardStatistic::route('/create'),
            'edit' => Pages\EditDashboardStatistic::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}