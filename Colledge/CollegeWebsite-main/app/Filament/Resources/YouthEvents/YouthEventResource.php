<?php

namespace App\Filament\Resources\YouthEvents;

use App\Filament\Resources\YouthEvents\Pages;
use App\Models\YouthEvent;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
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

class YouthEventResource extends Resource
{
    protected static ?string $model = YouthEvent::class;

    protected static ?string $navigationLabel = 'События молодежи';
    protected static ?string $modelLabel = 'Событие';
    protected static ?string $pluralModelLabel = 'События';
    
    protected static ?int $navigationSort = 20;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-calendar-days';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Молодежное движение';
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $upcoming = static::getModel()::where('is_published', true)
                ->where('type', 'upcoming')
                ->where('event_date', '>=', now())
                ->count();
            return $upcoming > 0 ? (string)$upcoming : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        Toggle::make('is_multilang')
                            ->label('Многоязычный контент')
                            ->default(true)
                            ->live()
                            ->helperText('Включите для контента на нескольких языках')
                            ->columnSpanFull(),
                    ]),

                Section::make('Название и описание события')
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
                                                    ->label('Название события на русском')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Например: Студенческий форум 2025')
                                                    ->columnSpanFull(),

                                                Textarea::make('short_description_ru')
                                                    ->label('Краткое описание на русском')
                                                    ->rows(2)
                                                    ->maxLength(300)
                                                    ->placeholder('Краткое описание для карточки события (до 300 символов)')
                                                    ->helperText('Отображается в карточке события')
                                                    ->columnSpanFull(),

                                                Textarea::make('description_ru')
                                                    ->label('Полное описание на русском')
                                                    ->required()
                                                    ->rows(5)
                                                    ->maxLength(5000)
                                                    ->placeholder('Подробное описание события, программа, цели и т.д.')
                                                    ->columnSpanFull(),
                                            ]),
                                        
                                        Tab::make('Қазақша')
                                            ->icon('heroicon-o-language')
                                            ->schema([
                                                TextInput::make('title_kk')
                                                    ->label('Оқиғаның қазақша атауы')
                                                    ->maxLength(255)
                                                    ->placeholder('Мысалы: 2025 жылғы студенттік форум')
                                                    ->columnSpanFull(),

                                                Textarea::make('short_description_kk')
                                                    ->label('Қазақша қысқаша сипаттама')
                                                    ->rows(2)
                                                    ->maxLength(300)
                                                    ->placeholder('Оқиға карточкасына арналған қысқаша сипаттама (300 таңбаға дейін)')
                                                    ->helperText('Оқиға карточкасында көрсетіледі')
                                                    ->columnSpanFull(),

                                                Textarea::make('description_kk')
                                                    ->label('Қазақша толық сипаттама')
                                                    ->rows(5)
                                                    ->maxLength(5000)
                                                    ->placeholder('Оқиғаның егжей-тегжейлі сипаттамасы, бағдарламасы, мақсаттары және т.б.')
                                                    ->columnSpanFull(),
                                            ]),
                                        
                                        Tab::make('English')
                                            ->icon('heroicon-o-language')
                                            ->schema([
                                                TextInput::make('title_en')
                                                    ->label('Event name in English')
                                                    ->maxLength(255)
                                                    ->placeholder('For example: Student Forum 2025')
                                                    ->columnSpanFull(),

                                                Textarea::make('short_description_en')
                                                    ->label('Short description in English')
                                                    ->rows(2)
                                                    ->maxLength(300)
                                                    ->placeholder('Short description for event card (up to 300 characters)')
                                                    ->helperText('Displayed in event card')
                                                    ->columnSpanFull(),

                                                Textarea::make('description_en')
                                                    ->label('Full description in English')
                                                    ->rows(5)
                                                    ->maxLength(5000)
                                                    ->placeholder('Detailed description of the event, program, goals, etc.')
                                                    ->columnSpanFull(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        return [
                            TextInput::make('title')
                                ->label('Название события')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Например: Студенческий форум 2025')
                                ->columnSpanFull(),

                            Textarea::make('short_description')
                                ->label('Краткое описание')
                                ->rows(2)
                                ->maxLength(300)
                                ->placeholder('Краткое описание для карточки события (до 300 символов)')
                                ->helperText('Отображается в карточке события')
                                ->columnSpanFull(),

                            Textarea::make('description')
                                ->label('Полное описание')
                                ->required()
                                ->rows(5)
                                ->maxLength(5000)
                                ->placeholder('Подробное описание события, программа, цели и т.д.')
                                ->columnSpanFull(),
                        ];
                    }),

                Section::make('Медиафайлы')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Главное изображение')
                            ->image()
                            ->disk('public_files')
                            ->directory('youth/events')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(5120)
                            ->helperText('Рекомендуемый размер: 1200x675px (16:9). Макс. 5 МБ')
                            ->columnSpanFull(),

                        FileUpload::make('gallery')
                            ->label('Галерея изображений')
                            ->image()
                            ->multiple()
                            ->disk('public_files')
                            ->directory('youth/events/gallery')
                            ->maxFiles(10)
                            ->maxSize(3072)
                            ->helperText('Загрузите до 10 фото. Макс. 3 МБ каждое')
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Дата, время и место')
                    ->schema(function (Get $get) {
                        $isMultilang = $get('is_multilang');
                        
                        $schema = [
                            DateTimePicker::make('event_date')
                                ->label('Дата и время события')
                                ->required()
                                ->native(false)
                                ->seconds(false)
                                ->displayFormat('d.m.Y H:i')
                                ->helperText('Дата и время начала события'),

                            TextInput::make('event_time')
                                ->label('Время (текстом)')
                                ->maxLength(255)
                                ->placeholder('Например: 15:00 - 18:00')
                                ->helperText('Можно указать дополнительно, если нужно'),
                        ];
                        
                        if ($isMultilang) {
                            $schema[] = TextInput::make('location_ru')
                                ->label('Место проведения на русском')
                                ->maxLength(255)
                                ->placeholder('Например: Актовый зал колледжа');
                            
                            $schema[] = TextInput::make('location_kk')
                                ->label('Өткізілетін орны қазақша')
                                ->maxLength(255)
                                ->placeholder('Мысалы: Колледждің акт залы');
                                
                            $schema[] = TextInput::make('location_en')
                                ->label('Location in English')
                                ->maxLength(255)
                                ->placeholder('For example: College assembly hall');
                        } else {
                            $schema[] = TextInput::make('location')
                                ->label('Место проведения')
                                ->maxLength(255)
                                ->placeholder('Например: Актовый зал колледжа');
                        }
                        
                        if ($isMultilang) {
                            $schema[] = TextInput::make('organizer_ru')
                                ->label('Организатор на русском')
                                ->maxLength(255)
                                ->placeholder('Например: Совет молодежи');
                            
                            $schema[] = TextInput::make('organizer_kk')
                                ->label('Ұйымдастырушы қазақша')
                                ->maxLength(255)
                                ->placeholder('Мысалы: Жастар кеңесі');
                                
                            $schema[] = TextInput::make('organizer_en')
                                ->label('Organizer in English')
                                ->maxLength(255)
                                ->placeholder('For example: Youth Council');
                        } else {
                            $schema[] = TextInput::make('organizer')
                                ->label('Организатор')
                                ->maxLength(255)
                                ->placeholder('Например: Совет молодежи');
                        }
                        
                        return $schema;
                    })->columns(2),

                Section::make('Тип и категория')
                    ->schema([
                        Select::make('type')
                            ->label('Тип события')
                            ->options([
                                'week_event' => '⭐ Событие недели',
                                'upcoming' => '📅 Ближайшее событие',
                                'archive' => '📦 Архив',
                            ])
                            ->required()
                            ->default('upcoming')
                            ->helperText('Событие недели будет отображаться в главном баннере'),

                        TagsInput::make('tags')
                            ->label('Теги события')
                            ->placeholder('Добавьте тег и нажмите Enter')
                            ->helperText('Например: спорт, культура, наука')
                            ->suggestions([
                                'спорт',
                                'культура',
                                'наука',
                                'искусство',
                                'волонтерство',
                                'образование',
                                'развлечение',
                            ])
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextInput::make('participants_count')
                            ->label('Количество участников')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Ожидаемое или фактическое количество'),

                        TextInput::make('registration_link')
                            ->label('Ссылка на регистрацию')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://forms.google.com/...')
                            ->helperText('Ссылка на форму регистрации участников'),
                    ])->columns(2),

                Section::make('Настройки публикации')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Избранное (Событие недели)')
                            ->helperText('Отображать в главном баннере на странице')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('type', 'week_event');
                                }
                            }),

                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(false)
                            ->helperText('Отображать событие на сайте'),

                        TextInput::make('order')
                            ->label('Порядок сортировки')
                            ->numeric()
                            ->default(0)
                            ->helperText('Чем меньше число, тем выше в списке'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap()
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

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'week_event' => 'Событие недели',
                        'upcoming' => 'Ближайшее',
                        'archive' => 'Архив',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'week_event',
                        'success' => 'upcoming',
                        'secondary' => 'archive',
                    ])
                    ->icon(fn (string $state): string => match ($state) {
                        'week_event' => 'heroicon-o-star',
                        'upcoming' => 'heroicon-o-calendar',
                        'archive' => 'heroicon-o-archive-box',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Дата события')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->event_date < now() ? 'gray' : 'success'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Место')
                    ->searchable()
                    ->toggleable()
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawLocation = $record->getRawOriginal('location');
                            if (is_string($rawLocation)) {
                                try {
                                    $data = json_decode($rawLocation, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Участники')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Избранное')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип события')
                    ->options([
                        'week_event' => 'Событие недели',
                        'upcoming' => 'Ближайшее',
                        'archive' => 'Архив',
                    ]),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Избранное'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Публикация'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),

                Tables\Filters\Filter::make('past_events')
                    ->label('Прошедшие события')
                    ->query(fn ($query) => $query->where('event_date', '<', now())),

                Tables\Filters\Filter::make('upcoming_events')
                    ->label('Предстоящие события')
                    ->query(fn ($query) => $query->where('event_date', '>=', now())),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('publish')
                    ->label('Опубликовать')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_published' => true])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('unpublish')
                    ->label('Снять с публикации')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_published' => false])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('warning'),

                BulkAction::make('delete')
                    ->label('Удалить выбранные')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->color('danger'),
            ])
            ->defaultSort('event_date', 'desc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouthEvents::route('/'),
            'create' => Pages\CreateYouthEvent::route('/create'),
            'edit' => Pages\EditYouthEvent::route('/{record}/edit'),
        ];
    }
}