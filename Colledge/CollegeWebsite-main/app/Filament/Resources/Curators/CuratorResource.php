<?php

namespace App\Filament\Resources\Curators;

use App\Filament\Resources\Curators\Pages;
use App\Models\Curator;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;

class CuratorResource extends Resource
{
    protected static ?string $model = Curator::class;

    protected static ?string $navigationLabel = 'Кураторы групп';
    protected static ?string $modelLabel = 'Куратор';
    protected static ?string $pluralModelLabel = 'Кураторы';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-academic-cap';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Настройки перевода')
                ->schema([
                    Toggle::make('is_multilang')
                        ->label('Многоязычный контент')
                        ->default(true)
                        ->live()
                        ->helperText('Включите для контента на нескольких языках')
                        ->columnSpanFull(),
                ]),

            Section::make('Основная информация')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('personal_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('curator_name_ru')
                                                ->label('ФИО Куратора на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Иванов Иван Иванович'),
                                            
                                            TextInput::make('curator_position_ru')
                                                ->label('Должность на русском')
                                                ->maxLength(255)
                                                ->placeholder('Например: Преподаватель информатики'),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('curator_name_kk')
                                                ->label('Куратордың аты-жөні қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Иванов Иван Иванович'),
                                            
                                            TextInput::make('curator_position_kk')
                                                ->label('Қызметі қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Ақпараттық технологиялар оқытушысы'),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('curator_name_en')
                                                ->label('Full name of curator in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Ivanov Ivan Ivanovich'),
                                            
                                            TextInput::make('curator_position_en')
                                                ->label('Position in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Computer Science Teacher'),
                                        ]),
                                ])->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('curator_name')
                            ->label('ФИО Куратора')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Иванов Иван Иванович'),

                        TextInput::make('curator_position')
                            ->label('Должность')
                            ->maxLength(255)
                            ->placeholder('Например: Преподаватель информатики'),
                    ];
                }),

            Section::make('Информация о группе')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('group_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('group_name_ru')
                                                ->label('Название группы на русском')
                                                ->placeholder('Например: ИС-21-1, БУ-22-2')
                                                ->required()
                                                ->maxLength(255),

                                            TextInput::make('specialty_ru')
                                                ->label('Специальность на русском')
                                                ->maxLength(255)
                                                ->placeholder('Например: Информационные системы')
                                                ->required(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('group_name_kk')
                                                ->label('Топтың атауы қазақша')
                                                ->placeholder('Мысалы: ИС-21-1, БУ-22-2')
                                                ->required()
                                                ->maxLength(255),

                                            TextInput::make('specialty_kk')
                                                ->label('Мамандығы қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Ақпараттық жүйелер')
                                                ->required(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('group_name_en')
                                                ->label('Group name in English')
                                                ->placeholder('For example: IS-21-1, BU-22-2')
                                                ->required()
                                                ->maxLength(255),

                                            TextInput::make('specialty_en')
                                                ->label('Specialty in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Information Systems')
                                                ->required(),
                                        ]),
                                ])->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('group_name')
                            ->label('Название группы')
                            ->placeholder('Например: ИС-21-1, БУ-22-2')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('specialty')
                            ->label('Специальность')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Информационные системы'),
                    ];
                }),

            Section::make('Дополнительная информация')
                ->schema([
                    Select::make('course')
                        ->label('Курс')
                        ->options([
                            1 => '1 курс',
                            2 => '2 курс',
                            3 => '3 курс',
                            4 => '4 курс',
                        ])
                        ->required()
                        ->default(1),

                    TextInput::make('students_count')
                        ->label('Количество студентов')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(50)
                        ->placeholder('Например: 25'),
                ])->columns(2),

            Section::make('Контактная информация и расписание')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('contact_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('room_number_ru')
                                                ->label('Номер кабинета на русском')
                                                ->placeholder('Например: 305, Корп. 2, каб. 201')
                                                ->maxLength(255),

                                            Textarea::make('consultation_schedule_ru')
                                                ->label('Расписание консультаций на русском')
                                                ->placeholder('Например: Понедельник 14:00-16:00, Среда 15:00-17:00')
                                                ->rows(3)
                                                ->columnSpanFull(),

                                            Textarea::make('additional_info_ru')
                                                ->label('Дополнительная информация на русском')
                                                ->placeholder('Любая дополнительная информация о группе')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('room_number_kk')
                                                ->label('Кабинет нөмірі қазақша')
                                                ->placeholder('Мысалы: 305, 2-көпе, каб. 201')
                                                ->maxLength(255),

                                            Textarea::make('consultation_schedule_kk')
                                                ->label('Консультация кестесі қазақша')
                                                ->placeholder('Мысалы: Дүйсенбі 14:00-16:00, Сәрсенбі 15:00-17:00')
                                                ->rows(3)
                                                ->columnSpanFull(),

                                            Textarea::make('additional_info_kk')
                                                ->label('Қосымша ақпарат қазақша')
                                                ->placeholder('Топ туралы қосымша ақпарат')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('room_number_en')
                                                ->label('Room number in English')
                                                ->placeholder('For example: 305, Building 2, Room 201')
                                                ->maxLength(255),

                                            Textarea::make('consultation_schedule_en')
                                                ->label('Consultation schedule in English')
                                                ->placeholder('For example: Monday 14:00-16:00, Wednesday 15:00-17:00')
                                                ->rows(3)
                                                ->columnSpanFull(),

                                            Textarea::make('additional_info_en')
                                                ->label('Additional information in English')
                                                ->placeholder('Any additional information about the group')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),
                                ])->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('room_number')
                            ->label('Номер кабинета')
                            ->placeholder('Например: 305, Корп. 2, каб. 201')
                            ->maxLength(255),

                        Textarea::make('consultation_schedule')
                            ->label('Расписание консультаций')
                            ->placeholder('Например: Понедельник 14:00-16:00, Среда 15:00-17:00')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('additional_info')
                            ->label('Дополнительная информация')
                            ->placeholder('Любая дополнительная информация о группе')
                            ->rows(3)
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Фотография и контакты')
                ->schema([
                    FileUpload::make('curator_photo')
                        ->label('Фотография куратора')
                        ->image()
                        ->avatar()
                        ->directory('curators/photos')
                        ->disk('public_files')
                        ->maxSize(2048)
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth(300)
                        ->imageResizeTargetHeight(300)
                        ->helperText('Рекомендуемый размер: 300x300 px, формат: JPG, PNG')
                        ->columnSpanFull()
                        ->alignCenter(),

                    TextInput::make('curator_email')
                        ->label('Email куратора')
                        ->email()
                        ->maxLength(255),

                    TextInput::make('curator_phone')
                        ->label('Телефон куратора')
                        ->tel()
                        ->maxLength(255),
                ])->columns(2),

            Section::make('Настройки отображения')
                ->schema([
                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),

                    Toggle::make('is_active')
                        ->label('Активен')
                        ->default(true)
                        ->helperText('Отображать на сайте'),
                ])->columns(2),
        ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('curator_photo')
                    ->label('Фото')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        if ($record?->curator_photo) {
                            return asset('uploads/' . $record->curator_photo);
                        }
                        $name = $record->curator_name ?? 'Куратор';
                        $initials = implode('', array_map(fn($word) => mb_substr($word, 0, 1), explode(' ', $name)));
                        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&color=7F9CF5&background=EBF4FF';
                    })
                    ->size(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('curator_name')
                    ->label('ФИО Куратора')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawFullName = $record->getRawOriginal('curator_name');
                            if (is_string($rawFullName)) {
                                try {
                                    $data = json_decode($rawFullName, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? 'Без имени';
                    }),

                Tables\Columns\TextColumn::make('group_name')
                    ->label('Группа')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('group_name');
                            if (is_string($rawData)) {
                                try {
                                    $data = json_decode($rawData, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\TextColumn::make('specialty')
                    ->label('Специальность')
                    ->searchable()
                    ->wrap()
                    ->limit(50)
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('specialty');
                            if (is_string($rawData)) {
                                try {
                                    $data = json_decode($rawData, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\TextColumn::make('course')
                    ->label('Курс')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => "{$state} курс")
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        1 => 'success',
                        2 => 'info',
                        3 => 'warning',
                        4 => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('students_count')
                    ->label('Студентов')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('room_number')
                    ->label('Кабинет')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('room_number');
                            if (is_string($rawData)) {
                                try {
                                    $data = json_decode($rawData, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? '';
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->tooltip('Многоязычный'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активность'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),
                    
                Tables\Filters\SelectFilter::make('course')
                    ->label('Курс')
                    ->options([
                        1 => '1 курс',
                        2 => '2 курс',
                        3 => '3 курс',
                        4 => '4 курс',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('course', 'asc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurators::route('/'),
            'create' => Pages\CreateCurators::route('/create'),
            'edit' => Pages\EditCurators::route('/{record}/edit'),
        ];
    }
}