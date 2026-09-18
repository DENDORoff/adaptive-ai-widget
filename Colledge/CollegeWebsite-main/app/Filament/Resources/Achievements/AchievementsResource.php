<?php

namespace App\Filament\Resources\Achievements;

use App\Filament\Resources\Achievements\Pages;
use App\Models\Achievement;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class AchievementsResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationLabel = 'Достижения';
    protected static ?string $modelLabel = 'Достижение';
    protected static ?string $pluralModelLabel = 'Достижения';
    protected static ?int $navigationSort = 10;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-trophy';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основная информация')
                ->schema([
                    Toggle::make('is_multilang')
                        ->label('Многоязычный контент')
                        ->default(true)
                        ->live()
                        ->helperText('Включите для контента на нескольких языках')
                        ->columnSpanFull(),
                ]),

            Section::make('Название и описание достижения')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_ru')
                                                ->label('Название достижения на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                                    $set('slug', Str::slug($state))
                                                )
                                                ->placeholder('Например: Международное партнёрство')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_ru')
                                                ->label('Описание на русском')
                                                ->required()
                                                ->rows(4)
                                                ->maxLength(500)
                                                ->placeholder('Расскажите о достижении подробнее...')
                                                ->helperText('Максимум 500 символов')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Жетістіктің қазақша атауы')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Халықаралық серіктестік')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_kk')
                                                ->label('Қазақша сипаттама')
                                                ->rows(4)
                                                ->maxLength(500)
                                                ->placeholder('Жетістік туралы егжей-тегжейлі айтыңыз...')
                                                ->helperText('Ең көбі 500 таңба')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Achievement name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: International partnership')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_en')
                                                ->label('Description in English')
                                                ->rows(4)
                                                ->maxLength(500)
                                                ->placeholder('Tell more about the achievement...')
                                                ->helperText('Maximum 500 characters')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Название достижения')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            )
                            ->placeholder('Например: Международное партнёрство')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание достижения')
                            ->required()
                            ->rows(4)
                            ->maxLength(500)
                            ->placeholder('Расскажите о достижении подробнее...')
                            ->helperText('Максимум 500 символов')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Детали')
                ->schema([
                    TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Автоматически генерируется из названия')
                        ->disabled()
                        ->dehydrated(),

                    Select::make('icon')
                        ->label('Иконка')
                        ->required()
                        ->options(Achievement::getAvailableIcons())
                        ->default('trophy')
                        ->helperText('Выберите иконку для карточки достижения'),

                    TextInput::make('year')
                        ->label('Год получения')
                        ->required()
                        ->maxLength(4)
                        ->default(date('Y'))
                        ->placeholder('2024')
                        ->helperText('Год, когда было получено достижение'),

                    TextInput::make('status')
                        ->label('Статус')
                        ->required()
                        ->maxLength(100)
                        ->default('Актуально')
                        ->placeholder('Актуально')
                        ->helperText('Статус достижения (не многоязычный)'),

                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->placeholder('0')
                        ->helperText('Чем меньше число, тем выше в списке'),
                ])->columns(2),

            Section::make('Публикация')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Активно')
                        ->default(true)
                        ->helperText('Отображать достижение на сайте'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->limit(50)
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawTitle = $record->getRawOriginal('title');
                            if (is_string($rawTitle)) {
                                try {
                                    $data = json_decode($rawTitle, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? 'Без названия';
                    }),

                Tables\Columns\TextColumn::make('icon')
                    ->label('Иконка')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => Achievement::getAvailableIcons()[$state] ?? $state),

                Tables\Columns\TextColumn::make('year')
                    ->label('Год')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'Актуально' => 'success',
                        'Архив' => 'gray',
                        'В процессе' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawStatus = $record->getRawOriginal('status');
                            if (is_string($rawStatus)) {
                                try {
                                    $data = json_decode($rawStatus, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активно')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Статус активности')
                    ->placeholder('Все')
                    ->trueLabel('Только активные')
                    ->falseLabel('Только скрытые'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус достижения')
                    ->options(Achievement::getStatuses()),
                    
                Tables\Filters\SelectFilter::make('icon')
                    ->label('Иконка')
                    ->options(Achievement::getAvailableIcons()),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('activate')
                    ->label('Активировать')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_active' => true])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('deactivate')
                    ->label('Скрыть')
                    ->icon('heroicon-o-eye-slash')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_active' => false])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('warning'),

                BulkAction::make('delete')
                    ->label('Удалить выбранных')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->color('danger'),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievements::route('/create'),
            'edit' => Pages\EditAchievements::route('/{record}/edit'),
        ];
    }
}