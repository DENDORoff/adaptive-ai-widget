<?php

namespace App\Filament\Resources\Staff;

use App\Filament\Resources\Staff\Pages;
use App\Models\Staff;
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

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationLabel = 'Сотрудники';
    protected static ?string $modelLabel = 'Сотрудник';
    protected static ?string $pluralModelLabel = 'Сотрудники';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-user-group';
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

            Section::make('Личная информация')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('personal_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('full_name_ru')
                                                ->label('ФИО на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Иванов Иван Иванович'),
                                            
                                            TextInput::make('position_ru')
                                                ->label('Должность на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Преподаватель информатики'),
                                            
                                            Textarea::make('bio_ru')
                                                ->label('Биография на русском')
                                                ->rows(4)
                                                ->placeholder('Краткая биография на русском языке')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('full_name_kk')
                                                ->label('Аты-жөні қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Иванов Иван Иванович'),
                                            
                                            TextInput::make('position_kk')
                                                ->label('Қызметі қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Ақпараттық технологиялар оқытушысы'),
                                            
                                            Textarea::make('bio_kk')
                                                ->label('Биографиясы қазақша')
                                                ->rows(4)
                                                ->placeholder('Қазақ тіліндегі қысқаша өмірбаяны')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('full_name_en')
                                                ->label('Full name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Ivanov Ivan Ivanovich'),
                                            
                                            TextInput::make('position_en')
                                                ->label('Position in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Computer Science Teacher'),
                                            
                                            Textarea::make('bio_en')
                                                ->label('Biography in English')
                                                ->rows(4)
                                                ->placeholder('Short biography in English')
                                                ->columnSpanFull(),
                                        ]),
                                ])->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('full_name')
                            ->label('ФИО')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Иванов Иван Иванович'),
                        
                        TextInput::make('position')
                            ->label('Должность')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Преподаватель информатики'),
                        
                        Textarea::make('bio')
                            ->label('Биография')
                            ->rows(4)
                            ->placeholder('Краткая биография сотрудника')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Контактная информация')
                ->schema([
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                    
                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->maxLength(255),
                ])->columns(2),

            Section::make('Фотография')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Фотография')
                        ->image()
                        ->disk('public_files')
                        ->directory('staff')
                        ->imageEditor()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('400')
                        ->columnSpanFull(),
                ]),

            Section::make('Образование и квалификация')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('education_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            Textarea::make('education_ru')
                                                ->label('Образование, год окончания на русском')
                                                ->rows(2)
                                                ->placeholder('Например: Высшее, КазНУ им. Аль-Фараби, 2010')
                                                ->columnSpanFull(),

                                            TextInput::make('diploma_specialty_ru')
                                                ->label('Специальность по диплому на русском')
                                                ->maxLength(255)
                                                ->placeholder('Например: Программное обеспечение вычислительной техники'),

                                            TextInput::make('diploma_qualification_ru')
                                                ->label('Квалификация по диплому на русском')
                                                ->maxLength(255)
                                                ->placeholder('Например: Инженер-программист'),

                                            Textarea::make('teaching_subjects_ru')
                                                ->label('Какой предмет (дисциплину) ведет на русском')
                                                ->rows(2)
                                                ->placeholder('Например: Программирование, Базы данных')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            Textarea::make('education_kk')
                                                ->label('Білімі, аяқтаған жылы қазақша')
                                                ->rows(2)
                                                ->placeholder('Мысалы: Жоғары, Әл-Фараби атындағы ҚазҰУ, 2010')
                                                ->columnSpanFull(),

                                            TextInput::make('diploma_specialty_kk')
                                                ->label('Диплом бойынша мамандығы қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Есептеу техникасының бағдарламалық жасақтамасы'),

                                            TextInput::make('diploma_qualification_kk')
                                                ->label('Диплом бойынша біліктілігі қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Инженер-бағдарламашы'),

                                            Textarea::make('teaching_subjects_kk')
                                                ->label('Қандай пән (дисциплина) жүргізеді қазақша')
                                                ->rows(2)
                                                ->placeholder('Мысалы: Бағдарламалау, Мәліметтер базасы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            Textarea::make('education_en')
                                                ->label('Education, year of graduation in English')
                                                ->rows(2)
                                                ->placeholder('For example: Higher, al-Farabi Kazakh National University, 2010')
                                                ->columnSpanFull(),

                                            TextInput::make('diploma_specialty_en')
                                                ->label('Diploma specialty in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Computer Software'),

                                            TextInput::make('diploma_qualification_en')
                                                ->label('Diploma qualification in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Software Engineer'),

                                            Textarea::make('teaching_subjects_en')
                                                ->label('Subjects taught in English')
                                                ->rows(2)
                                                ->placeholder('For example: Programming, Databases')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        Textarea::make('education')
                            ->label('Образование, год окончания')
                            ->rows(2)
                            ->placeholder('Например: Высшее, КазНУ им. Аль-Фараби, 2010')
                            ->columnSpanFull(),

                        TextInput::make('diploma_specialty')
                            ->label('Специальность по диплому')
                            ->maxLength(255)
                            ->placeholder('Например: Программное обеспечение вычислительной техники'),

                        TextInput::make('diploma_qualification')
                            ->label('Квалификация по диплому')
                            ->maxLength(255)
                            ->placeholder('Например: Инженер-программист'),

                        Textarea::make('teaching_subjects')
                            ->label('Какой предмет (дисциплину) ведет')
                            ->rows(2)
                            ->placeholder('Например: Программирование, Базы данных')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Стаж и категория')
                ->schema(function (\Filament\Schemas\Components\Utilities\Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('experience_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('work_experience_total_ru')
                                                ->label('Общий стаж работы на русском')
                                                ->placeholder('Например: 15 лет'),

                                            TextInput::make('work_experience_pedagogical_ru')
                                                ->label('Педагогический стаж на русском')
                                                ->placeholder('Например: 10 лет'),

                                            TextInput::make('category_ru')
                                                ->label('Категория на русском')
                                                ->maxLength(255)
                                                ->placeholder('Например: Высшая'),

                                            Textarea::make('awards_ru')
                                                ->label('Награды на русском')
                                                ->rows(2)
                                                ->placeholder('Например: Почетная грамота МОН РК, 2020')
                                                ->columnSpanFull(),

                                            Textarea::make('professional_development_ru')
                                                ->label('Курсы повышения квалификации на русском')
                                                ->rows(2)
                                                ->placeholder('Например: Курсы "Современные технологии обучения", 2023')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('work_experience_total_kk')
                                                ->label('Жалпы еңбек өтілі қазақша')
                                                ->placeholder('Мысалы: 15 жыл'),

                                            TextInput::make('work_experience_pedagogical_kk')
                                                ->label('Педагогикалық өтілі қазақша')
                                                ->placeholder('Мысалы: 10 жыл'),

                                            TextInput::make('category_kk')
                                                ->label('Санаты қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Жоғары'),

                                            Textarea::make('awards_kk')
                                                ->label('Мадақтамалары қазақша')
                                                ->rows(2)
                                                ->placeholder('Мысалы: ҚР БҒМ құрмет грамотасы, 2020')
                                                ->columnSpanFull(),

                                            Textarea::make('professional_development_kk')
                                                ->label('Біліктілігін арттыру курстары қазақша')
                                                ->rows(2)
                                                ->placeholder('Мысалы: "Қазіргі заманғы оқыту технологиялары" курстары, 2023')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('work_experience_total_en')
                                                ->label('Total work experience in English')
                                                ->placeholder('For example: 15 years'),

                                            TextInput::make('work_experience_pedagogical_en')
                                                ->label('Pedagogical experience in English')
                                                ->placeholder('For example: 10 years'),

                                            TextInput::make('category_en')
                                                ->label('Category in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Highest'),

                                            Textarea::make('awards_en')
                                                ->label('Awards in English')
                                                ->rows(2)
                                                ->placeholder('For example: Honorary Diploma of the Ministry of Education, 2020')
                                                ->columnSpanFull(),

                                            Textarea::make('professional_development_en')
                                                ->label('Professional development courses in English')
                                                ->rows(2)
                                                ->placeholder('For example: "Modern Teaching Technologies" courses, 2023')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('work_experience_total')
                            ->label('Общий стаж работы')
                            ->placeholder('Например: 15 лет'),

                        TextInput::make('work_experience_pedagogical')
                            ->label('Педагогический стаж')
                            ->placeholder('Например: 10 лет'),

                        TextInput::make('category')
                            ->label('Категория')
                            ->maxLength(255)
                            ->placeholder('Например: Высшая'),

                        Textarea::make('awards')
                            ->label('Награды')
                            ->rows(2)
                            ->placeholder('Например: Почетная грамота МОН РК, 2020')
                            ->columnSpanFull(),

                        Textarea::make('professional_development')
                            ->label('Курсы повышения квалификации')
                            ->rows(2)
                            ->placeholder('Например: Курсы "Современные технологии обучения", 2023')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Дополнительная информация')
                ->schema([
                    Select::make('department')
                        ->label('Отделение')
                        ->options(function () {
                            $existing = Staff::getDepartments()->mapWithKeys(fn ($dept) => [$dept => $dept])->toArray();
                            
                            $defaults = [
                                'Информационные технологии' => 'Информационные технологии',
                                'Экономика и управление' => 'Экономика и управление',
                                'Строительство' => 'Строительство',
                                'Транспорт' => 'Транспорт',
                                'Медицина' => 'Медицина',
                            ];
                            
                            return array_merge($defaults, $existing);
                        })
                        ->searchable()
                        ->preload()
                        ->allowHtml(false)
                        ->native(false)
                        ->helperText('Выберите отделение'),

                    TextInput::make('specialty')
                        ->label('Специальность')
                        ->maxLength(255)
                        ->helperText('Например: Программирование'),
                ])->columns(2),

            Section::make('Настройки отображения')
                ->schema([
                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),
                    
                    Toggle::make('is_leadership')
                        ->label('Руководство колледжа')
                        ->helperText('Отображать в разделе руководства'),
                ])->columns(2),
        ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Фото')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        if ($record?->photo) {
                            return asset('uploads/' . $record->photo);
                        }
                        return asset('uploads/staff/default-avatar.jpg');
                    }),
                
                Tables\Columns\TextColumn::make('full_name')
                    ->label('ФИО')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawFullName = $record->getRawOriginal('full_name');
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
                
                Tables\Columns\TextColumn::make('position')
                    ->label('Должность')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('position');
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
                
                Tables\Columns\TextColumn::make('department')
                    ->label('Отделение')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('teaching_subjects')
                    ->label('Предметы')
                    ->searchable()
                    ->limit(30)
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('teaching_subjects');
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

                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('category');
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

                Tables\Columns\TextColumn::make('work_experience_pedagogical')
                    ->label('Пед. стаж')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('work_experience_pedagogical');
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
                
                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->tooltip('Многоязычный'),
                
                Tables\Columns\TextColumn::make('specialty')
                    ->label('Специальность')
                    ->searchable()
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
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email скопирован!')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Телефон скопирован!')
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('is_leadership')
                    ->label('Руководство')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_leadership')
                    ->label('Руководство'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),
                    
                Tables\Filters\SelectFilter::make('department')
                    ->label('Отделение')
                    ->options(fn () => Staff::getDepartments()->mapWithKeys(fn ($dept) => [$dept => $dept])),
                    
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options([
                        'Высшая' => 'Высшая',
                        'Первая' => 'Первая',
                        'Вторая' => 'Вторая',
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
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}