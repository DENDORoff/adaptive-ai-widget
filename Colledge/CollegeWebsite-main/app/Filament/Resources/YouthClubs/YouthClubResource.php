<?php

namespace App\Filament\Resources\YouthClubs;

use App\Filament\Resources\YouthClubs\Pages;
use App\Models\YouthClub;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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

class YouthClubResource extends Resource
{
    protected static ?string $model = YouthClub::class;

    protected static ?string $navigationLabel = 'Кружки и секции';
    protected static ?string $modelLabel = 'Кружок';
    protected static ?string $pluralModelLabel = 'Кружки и секции';
    
    protected static ?int $navigationSort = 22;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-puzzle-piece';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Молодежное движение';
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $recruiting = static::getModel()::where('is_published', true)
                ->where('is_recruiting', true)
                ->count();
            return $recruiting > 0 ? (string)$recruiting : null;
        } catch (\Exception $e) {
            return null;
        }
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

            Section::make('Название и описание кружка')
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
                                                ->label('Название кружка/секции на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Студенческий театр')
                                                ->columnSpanFull(),

                                            Textarea::make('short_description_ru')
                                                ->label('Краткое описание на русском')
                                                ->rows(2)
                                                ->maxLength(300)
                                                ->placeholder('Краткое описание для карточки (до 300 символов)')
                                                ->helperText('Отображается в карточке кружка')
                                                ->columnSpanFull(),

                                            Textarea::make('description_ru')
                                                ->label('Полное описание на русском')
                                                ->required()
                                                ->rows(5)
                                                ->maxLength(5000)
                                                ->placeholder('Подробное описание деятельности кружка, чему научатся участники')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('name_kk')
                                                ->label('Үйірме/секцияның қазақша атауы')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Студенттік театр')
                                                ->columnSpanFull(),

                                            Textarea::make('short_description_kk')
                                                ->label('Қазақша қысқаша сипаттама')
                                                ->rows(2)
                                                ->maxLength(300)
                                                ->placeholder('Карточкаға арналған қысқаша сипаттама (300 таңбаға дейін)')
                                                ->helperText('Үйірме карточкасында көрсетіледі')
                                                ->columnSpanFull(),

                                            Textarea::make('description_kk')
                                                ->label('Қазақша толық сипаттама')
                                                ->rows(5)
                                                ->maxLength(5000)
                                                ->placeholder('Үйірме қызметінің егжей-тегжейлі сипаттамасы, қатысушылар не үйренетіні туралы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('name_en')
                                                ->label('Club/section name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Student Theater')
                                                ->columnSpanFull(),

                                            Textarea::make('short_description_en')
                                                ->label('Short description in English')
                                                ->rows(2)
                                                ->maxLength(300)
                                                ->placeholder('Short description for card (up to 300 characters)')
                                                ->helperText('Displayed in club card')
                                                ->columnSpanFull(),

                                            Textarea::make('description_en')
                                                ->label('Full description in English')
                                                ->rows(5)
                                                ->maxLength(5000)
                                                ->placeholder('Detailed description of the club\'s activities, what participants will learn')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('name')
                            ->label('Название кружка/секции')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Студенческий театр')
                            ->columnSpanFull(),

                        Textarea::make('short_description')
                            ->label('Краткое описание')
                            ->rows(2)
                            ->maxLength(300)
                            ->placeholder('Краткое описание для карточки (до 300 символов)')
                            ->helperText('Отображается в карточке кружка')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Полное описание')
                            ->required()
                            ->rows(5)
                            ->maxLength(5000)
                            ->placeholder('Подробное описание деятельности кружка, чему научатся участники')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Визуальное оформление')
                ->schema([
                    Select::make('icon')
                        ->label('Иконка (Font Awesome)')
                        ->options([
                            'fas fa-star' => '⭐ Звезда',
                            'fas fa-paint-brush' => '🎨 Кисть',
                            'fas fa-music' => '🎵 Музыка',
                            'fas fa-running' => '🏃 Бег',
                            'fas fa-theater-masks' => '🎭 Театр',
                            'fas fa-camera' => '📷 Камера',
                            'fas fa-chess' => '♟️ Шахматы',
                            'fas fa-code' => '💻 Код',
                            'fas fa-book' => '📚 Книга',
                            'fas fa-microphone' => '🎤 Микрофон',
                            'fas fa-palette' => '🎨 Палитра',
                            'fas fa-guitar' => '🎸 Гитара',
                            'fas fa-basketball-ball' => '🏀 Баскетбол',
                            'fas fa-film' => '🎬 Кино',
                            'fas fa-hands-helping' => '🤝 Помощь',
                        ])
                        ->required()
                        ->default('fas fa-star')
                        ->searchable(),

                    Select::make('color')
                        ->label('Цвет темы')
                        ->options([
                            'blue' => '🔵 Синий',
                            'green' => '🟢 Зеленый',
                            'red' => '🔴 Красный',
                            'purple' => '🟣 Фиолетовый',
                            'yellow' => '🟡 Желтый',
                            'pink' => '🩷 Розовый',
                            'orange' => '🟠 Оранжевый',
                            'teal' => '🩵 Бирюзовый',
                        ])
                        ->required()
                        ->default('blue'),

                    FileUpload::make('image')
                        ->label('Главное изображение')
                        ->image()
                        ->disk('public_files')
                        ->directory('youth/clubs')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->helperText('Изображение кружка. Макс. 5 МБ')
                        ->columnSpanFull(),

                    FileUpload::make('gallery')
                        ->label('Галерея фото')
                        ->image()
                        ->multiple()
                        ->disk('public_files')
                        ->directory('youth/clubs/gallery')
                        ->maxFiles(10)
                        ->maxSize(3072)
                        ->helperText('До 10 фото деятельности кружка. Макс. 3 МБ каждое')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Категория и расписание')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    $schema = [
                        Select::make('category')
                            ->label('Категория')
                            ->options([
                                'sport' => '⚽ Спорт',
                                'art' => '🎨 Искусство',
                                'science' => '🔬 Наука',
                                'technology' => '💻 Технологии',
                                'music' => '🎵 Музыка',
                                'dance' => '💃 Танцы',
                                'theater' => '🎭 Театр',
                                'volunteer' => '🤝 Волонтерство',
                                'other' => '📌 Другое',
                            ])
                            ->required()
                            ->default('other')
                            ->searchable(),
                    ];
                    
                    if ($isMultilang) {
                        $schema[] = TextInput::make('schedule_ru')
                            ->label('Расписание занятий на русском')
                            ->maxLength(255)
                            ->placeholder('Например: Понедельник, Среда 15:00-17:00')
                            ->helperText('Укажите дни и время занятий');
                            
                        $schema[] = TextInput::make('schedule_kk')
                            ->label('Қазақша сабақ кестесі')
                            ->maxLength(255)
                            ->placeholder('Мысалы: Дүйсенбі, Сәрсенбі 15:00-17:00')
                            ->helperText('Сабақ күндері мен уақытын көрсетіңіз');
                            
                        $schema[] = TextInput::make('schedule_en')
                            ->label('Schedule in English')
                            ->maxLength(255)
                            ->placeholder('For example: Monday, Wednesday 15:00-17:00')
                            ->helperText('Specify days and times of classes');
                            
                        $schema[] = TextInput::make('location_ru')
                            ->label('Место проведения на русском')
                            ->maxLength(255)
                            ->placeholder('Например: Главный корпус');
                            
                        $schema[] = TextInput::make('location_kk')
                            ->label('Өткізілетін орны қазақша')
                            ->maxLength(255)
                            ->placeholder('Мысалы: Негізгі ғимарат');
                            
                        $schema[] = TextInput::make('location_en')
                            ->label('Location in English')
                            ->maxLength(255)
                            ->placeholder('For example: Main building');
                            
                        $schema[] = TextInput::make('room_ru')
                            ->label('Кабинет/Помещение на русском')
                            ->maxLength(255)
                            ->placeholder('Например: Аудитория 305');
                            
                        $schema[] = TextInput::make('room_kk')
                            ->label('Кабинет/Бөлме қазақша')
                            ->maxLength(255)
                            ->placeholder('Мысалы: 305 аудитория');
                            
                        $schema[] = TextInput::make('room_en')
                            ->label('Room in English')
                            ->maxLength(255)
                            ->placeholder('For example: Room 305');
                    } else {
                        $schema[] = TextInput::make('schedule')
                            ->label('Расписание занятий')
                            ->maxLength(255)
                            ->placeholder('Например: Понедельник, Среда 15:00-17:00')
                            ->helperText('Укажите дни и время занятий');

                        $schema[] = TextInput::make('location')
                            ->label('Место проведения')
                            ->maxLength(255)
                            ->placeholder('Например: Главный корпус');

                        $schema[] = TextInput::make('room')
                            ->label('Кабинет/Помещение')
                            ->maxLength(255)
                            ->placeholder('Например: Аудитория 305');
                    }
                    
                    return $schema;
                })->columns(2),

            Section::make('Руководитель кружка')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    $schema = [
                        TextInput::make('instructor_phone')
                            ->label('Телефон')
                            ->tel()
                            ->maxLength(50)
                            ->placeholder('+7 (777) 123-45-67'),

                        TextInput::make('instructor_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('instructor@college.kz'),

                        FileUpload::make('instructor_photo')
                            ->label('Фото руководителя')
                            ->image()
                            ->disk('public_files')
                            ->directory('youth/instructors')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Фото руководителя. Макс. 2 МБ'),
                    ];
                    
                    if ($isMultilang) {
                        $schema[] = TextInput::make('instructor_name_ru')
                            ->label('ФИО руководителя на русском')
                            ->maxLength(255)
                            ->placeholder('Иванов Иван Иванович');
                            
                        $schema[] = TextInput::make('instructor_name_kk')
                            ->label('Жетекшінің толық аты-жөні қазақша')
                            ->maxLength(255)
                            ->placeholder('Иванов Иван Иванович');
                            
                        $schema[] = TextInput::make('instructor_name_en')
                            ->label('Instructor full name in English')
                            ->maxLength(255)
                            ->placeholder('Ivanov Ivan Ivanovich');
                    } else {
                        array_unshift($schema, 
                            TextInput::make('instructor_name')
                                ->label('ФИО руководителя')
                                ->maxLength(255)
                                ->placeholder('Иванов Иван Иванович')
                        );
                    }
                    
                    return $schema;
                })->columns(2),

            Section::make('Параметры участия')
                ->schema([
                    TextInput::make('max_participants')
                        ->label('Макс. участников')
                        ->numeric()
                        ->minValue(1)
                        ->placeholder('30')
                        ->helperText('Максимальное количество участников (оставьте пустым для неограниченного)'),

                    TextInput::make('current_participants')
                        ->label('Текущее кол-во')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Текущее количество зарегистрированных участников'),

                    TextInput::make('age_min')
                        ->label('Минимальный возраст')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(99)
                        ->placeholder('14'),

                    TextInput::make('age_max')
                        ->label('Максимальный возраст')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(99)
                        ->placeholder('25'),

                    TextInput::make('price')
                        ->label('Стоимость (₸)')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->prefix('₸')
                        ->helperText('Стоимость участия (0 = бесплатно)'),

                    TextInput::make('registration_link')
                        ->label('Ссылка на регистрацию')
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://forms.google.com/...')
                        ->helperText('Ссылка на форму регистрации')
                        ->columnSpanFull(),
                ])->columns(3),

            Section::make('Достижения кружка')
                ->schema([
                    Repeater::make('achievements')
                        ->label('Достижения')
                        ->schema([
                            TextInput::make('title')
                                ->label('Название достижения')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Например: 1 место в областном конкурсе'),

                            TextInput::make('year')
                                ->label('Год')
                                ->numeric()
                                ->minValue(2000)
                                ->maxValue(2100)
                                ->placeholder('2024'),
                        ])
                        ->columns(2)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->addActionLabel('Добавить достижение')
                        ->columnSpanFull(),
                ]),

            Section::make('Настройки публикации')
                ->schema([
                    Toggle::make('is_recruiting')
                        ->label('Идет набор')
                        ->default(true)
                        ->helperText('Открыт ли набор в кружок'),

                    Toggle::make('is_featured')
                        ->label('Избранное')
                        ->helperText('Отображать в топе на странице'),

                    Toggle::make('is_published')
                        ->label('Опубликовано')
                        ->default(false)
                        ->helperText('Отображать кружок на сайте'),

                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),
                ])->columns(4),
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
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
                        return $state ?? 'Без названия';
                    }),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Категория')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sport' => 'Спорт',
                        'art' => 'Искусство',
                        'science' => 'Наука',
                        'technology' => 'Технологии',
                        'music' => 'Музыка',
                        'dance' => 'Танцы',
                        'theater' => 'Театр',
                        'volunteer' => 'Волонтерство',
                        'other' => 'Другое',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'sport',
                        'warning' => 'art',
                        'info' => 'science',
                        'primary' => 'technology',
                        'danger' => 'music',
                        'secondary' => 'dance',
                    ]),

                Tables\Columns\TextColumn::make('instructor_name')
                    ->label('Руководитель')
                    ->searchable()
                    ->toggleable()
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawInstructorName = $record->getRawOriginal('instructor_name');
                            if (is_string($rawInstructorName)) {
                                try {
                                    $data = json_decode($rawInstructorName, true);
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
                    ->state(function ($record) {
                        if (!$record->max_participants) {
                            return $record->current_participants;
                        }
                        return "{$record->current_participants}/{$record->max_participants}";
                    })
                    ->badge()
                    ->color(fn ($record) => 
                        !$record->max_participants ? 'info' : 
                        ($record->current_participants >= $record->max_participants ? 'danger' : 'success')
                    ),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->formatStateUsing(fn ($state) => $state == 0 ? 'Бесплатно' : number_format($state, 0, '.', ' ') . ' ₸')
                    ->badge()
                    ->color(fn ($state) => $state == 0 ? 'success' : 'warning'),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_recruiting')
                    ->label('Набор')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

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
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options([
                        'sport' => 'Спорт',
                        'art' => 'Искусство',
                        'science' => 'Наука',
                        'technology' => 'Технологии',
                        'music' => 'Музыка',
                        'dance' => 'Танцы',
                        'theater' => 'Театр',
                        'volunteer' => 'Волонтерство',
                        'other' => 'Другое',
                    ]),

                Tables\Filters\TernaryFilter::make('is_recruiting')
                    ->label('Идет набор'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Избранные'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Публикация'),

                Tables\Filters\Filter::make('free')
                    ->label('Бесплатные')
                    ->query(fn ($query) => $query->where('price', 0)),

                Tables\Filters\Filter::make('has_spots')
                    ->label('Есть свободные места')
                    ->query(fn ($query) => $query->whereRaw('current_participants < max_participants OR max_participants IS NULL')),
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
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouthClubs::route('/'),
            'create' => Pages\CreateYouthClub::route('/create'),
            'edit' => Pages\EditYouthClub::route('/{record}/edit'),
        ];
    }
}