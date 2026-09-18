<?php

namespace App\Filament\Resources\Graduates;

use App\Filament\Resources\Graduates\Pages;
use App\Models\Graduate;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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

class GraduatesResource extends Resource
{
    protected static ?string $model = Graduate::class;

    protected static ?string $navigationLabel = 'Выпускники';
    protected static ?string $modelLabel = 'Выпускник';
    protected static ?string $pluralModelLabel = 'Выпускники';
    protected static ?int $navigationSort = 11;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-academic-cap';
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

            Section::make('Информация о выпускнике')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('name_ru')
                                                ->label('ФИО выпускника на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                                    $set('slug', Str::slug($state))
                                                )
                                                ->placeholder('Например: Иванов Иван Иванович')
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('specialty_ru')
                                                ->label('Специальность на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Программирование'),
                                            
                                            TextInput::make('position_ru')
                                                ->label('Текущая должность на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Senior Developer в Google'),
                                            
                                            Textarea::make('story_ru')
                                                ->label('История выпускника на русском')
                                                ->required()
                                                ->rows(5)
                                                ->maxLength(1000)
                                                ->placeholder('Расскажите об успехах и достижениях выпускника...')
                                                ->helperText('Максимум 1000 символов')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('name_kk')
                                                ->label('Тұлғаның толық аты-жөні қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Иванов Иван Иванович')
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('specialty_kk')
                                                ->label('Мамандығы қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Бағдарламалау'),
                                            
                                            TextInput::make('position_kk')
                                                ->label('Қазіргі лауазымы қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Google компаниясындағы аға әзірлеуші'),
                                            
                                            Textarea::make('story_kk')
                                                ->label('Тұлғаның тарихы қазақша')
                                                ->rows(5)
                                                ->maxLength(1000)
                                                ->placeholder('Тұлғаның жетістіктері мен табыстары туралы айтыңыз...')
                                                ->helperText('Ең көбі 1000 таңба')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('name_en')
                                                ->label('Graduate full name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Ivanov Ivan Ivanovich')
                                                ->columnSpanFull(),
                                            
                                            TextInput::make('specialty_en')
                                                ->label('Specialty in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Programming'),
                                            
                                            TextInput::make('position_en')
                                                ->label('Current position in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Senior Developer at Google'),
                                            
                                            Textarea::make('story_en')
                                                ->label('Graduate story in English')
                                                ->rows(5)
                                                ->maxLength(1000)
                                                ->placeholder('Tell about the graduate\'s successes and achievements...')
                                                ->helperText('Maximum 1000 characters')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('name')
                            ->label('ФИО выпускника')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            )
                            ->placeholder('Например: Иванов Иван Иванович')
                            ->columnSpanFull(),

                        TextInput::make('specialty')
                            ->label('Специальность')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Программирование'),

                        TextInput::make('position')
                            ->label('Текущая должность')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Senior Developer в Google'),
                    ];
                }),

            Section::make('История успеха')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if (!$isMultilang) {
                        return [
                            Textarea::make('story')
                                ->label('История выпускника')
                                ->required()
                                ->rows(5)
                                ->maxLength(1000)
                                ->placeholder('Расскажите об успехах и достижениях выпускника...')
                                ->helperText('Максимум 1000 символов')
                                ->columnSpanFull(),
                        ];
                    }
                    return [];
                }),

            Section::make('Фотография')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Фото выпускника')
                        ->image()
                        ->disk('public')
                        ->directory('graduates')
                        ->maxSize(5120) // 5MB
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('400')
                        ->helperText('Рекомендуемый размер: 400x400px. Макс. 5 МБ. Если фото не загружено, будет сгенерирован аватар.')
                        ->columnSpanFull(),
                ]),

            Section::make('Дополнительная информация')
                ->schema([
                    TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Автоматически генерируется из имени')
                        ->disabled()
                        ->dehydrated(),

                    TextInput::make('graduation_year')
                        ->label('Год выпуска')
                        ->maxLength(4)
                        ->placeholder('2020')
                        ->helperText('Год окончания колледжа'),

                    TextInput::make('company')
                        ->label('Компания')
                        ->maxLength(255)
                        ->placeholder('Например: Google')
                        ->helperText('Текущее место работы'),

                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->placeholder('0')
                        ->helperText('Чем меньше число, тем выше в списке'),
                ])->columns(4),

            Section::make('Публикация')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Активно')
                        ->default(true)
                        ->helperText('Отображать выпускника на сайте'),
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

                Tables\Columns\ImageColumn::make('photo')
                    ->label('Фото')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 
                        'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&size=80&background=3b82f6&color=fff'
                    )
                    ->width(60)
                    ->height(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('ФИО')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawName = $record->getRawOriginal('name');
                            if (is_string($rawName)) {
                                try {
                                    $data = json_decode($rawName, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? 'Без имени';
                    }),

                Tables\Columns\TextColumn::make('specialty')
                    ->label('Специальность')
                    ->searchable()
                    ->limit(30)
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawSpecialty = $record->getRawOriginal('specialty');
                            if (is_string($rawSpecialty)) {
                                try {
                                    $data = json_decode($rawSpecialty, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\TextColumn::make('position')
                    ->label('Должность')
                    ->searchable()
                    ->limit(30)
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawPosition = $record->getRawOriginal('position');
                            if (is_string($rawPosition)) {
                                try {
                                    $data = json_decode($rawPosition, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\TextColumn::make('graduation_year')
                    ->label('Год выпуска')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('company')
                    ->label('Компания')
                    ->searchable()
                    ->limit(20)
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawCompany = $record->getRawOriginal('company');
                            if (is_string($rawCompany)) {
                                try {
                                    $data = json_decode($rawCompany, true);
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
                    
                Tables\Filters\Filter::make('has_photo')
                    ->label('С фотографией')
                    ->query(fn ($query) => $query->whereNotNull('photo')),
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
            'index' => Pages\ListGraduates::route('/'),
            'create' => Pages\CreateGraduates::route('/create'),
            'edit' => Pages\EditGraduates::route('/{record}/edit'),
        ];
    }
}