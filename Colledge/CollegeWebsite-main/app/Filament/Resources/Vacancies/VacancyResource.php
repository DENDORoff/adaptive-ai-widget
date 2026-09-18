<?php

namespace App\Filament\Resources\Vacancies;

use App\Filament\Resources\Vacancies\Pages;
use App\Models\Vacancy;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Illuminate\Support\Str;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationLabel = 'Вакансии';
    protected static ?string $modelLabel = 'Вакансия';
    protected static ?string $pluralModelLabel = 'Вакансии';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-briefcase';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::published()->count() ?: null;
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

            Section::make('Название и описание вакансии')
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
                                                ->label('Название вакансии на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                                    $set('slug', Str::slug($state))
                                                ),
                                            
                                            Textarea::make('description_ru')
                                                ->label('Краткое описание на русском')
                                                ->required()
                                                ->rows(4)
                                                ->helperText('Отображается в виджете на странице вакансий')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Вакансияның қазақша атауы')
                                                ->maxLength(255)
                                                ->live(onBlur: true),
                                            
                                            Textarea::make('description_kk')
                                                ->label('Қазақша қысқаша сипаттама')
                                                ->rows(4)
                                                ->helperText('Вакансиялар бетіндегі виджетте көрсетіледі')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Vacancy name in English')
                                                ->maxLength(255)
                                                ->live(onBlur: true),
                                            
                                            Textarea::make('description_en')
                                                ->label('Brief description in English')
                                                ->rows(4)
                                                ->helperText('Displayed in the widget on the vacancies page')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Название вакансии')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (callable $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->label('URL (slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Автоматически генерируется из названия'),

                        Textarea::make('description')
                            ->label('Краткое описание')
                            ->required()
                            ->rows(4)
                            ->helperText('Отображается в виджете на странице вакансий')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Детали вакансии')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('details_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('salary_ru')
                                                ->label('Зарплата')
                                                ->placeholder('Например: 150 000 - 200 000 ₸')
                                                ->maxLength(255),
                                            
                                            TextInput::make('location_ru')
                                                ->label('Местоположение')
                                                ->placeholder('Например: г. Павлодар')
                                                ->maxLength(255),
                                            
                                            Select::make('employment_type_ru')
                                                ->label('Тип занятости')
                                                ->options([
                                                    'Полная занятость' => 'Полная занятость',
                                                    'Частичная занятость' => 'Частичная занятость',
                                                    'Временная работа' => 'Временная работа',
                                                    'Проектная работа' => 'Проектная работа',
                                                ])
                                                ->searchable(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('salary_kk')
                                                ->label('Жалақы')
                                                ->placeholder('Мысалы: 150 000 - 200 000 ₸')
                                                ->maxLength(255),
                                            
                                            TextInput::make('location_kk')
                                                ->label('Орналасқан жері')
                                                ->placeholder('Мысалы: Павлодар қаласы')
                                                ->maxLength(255),
                                            
                                            Select::make('employment_type_kk')
                                                ->label('Жұмыс түрі')
                                                ->options([
                                                    'Толық жұмыс уақыты' => 'Толық жұмыс уақыты',
                                                    'Жартылай жұмыс уақыты' => 'Жартылай жұмыс уақыты',
                                                    'Уақытша жұмыс' => 'Уақытша жұмыс',
                                                    'Жобалық жұмыс' => 'Жобалық жұмыс',
                                                ])
                                                ->searchable(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('salary_en')
                                                ->label('Salary')
                                                ->placeholder('For example: 150,000 - 200,000 ₸')
                                                ->maxLength(255),
                                            
                                            TextInput::make('location_en')
                                                ->label('Location')
                                                ->placeholder('For example: Pavlodar city')
                                                ->maxLength(255),
                                            
                                            Select::make('employment_type_en')
                                                ->label('Employment type')
                                                ->options([
                                                    'Full-time' => 'Full-time',
                                                    'Part-time' => 'Part-time',
                                                    'Temporary work' => 'Temporary work',
                                                    'Project work' => 'Project work',
                                                ])
                                                ->searchable(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('salary')
                            ->label('Зарплата')
                            ->placeholder('Например: 150 000 - 200 000 ₸')
                            ->maxLength(255),

                        TextInput::make('location')
                            ->label('Местоположение')
                            ->placeholder('Например: г. Павлодар')
                            ->maxLength(255),

                        Select::make('employment_type')
                            ->label('Тип занятости')
                            ->options([
                                'Полная занятость' => 'Полная занятость',
                                'Частичная занятости' => 'Частичная занятость',
                                'Временная работа' => 'Временная работа',
                                'Проектная работа' => 'Проектная работа',
                            ])
                            ->searchable(),
                    ];
                }),

            Section::make('PDF документ')
                ->schema([
                    FileUpload::make('pdf_file')
                        ->label('PDF файл с подробностями')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required()
                        ->disk('public_files')
                        ->directory('vacancies')
                        ->maxSize(10240) // 10MB
                        ->helperText('Загрузите PDF файл с полным описанием вакансии (макс. 10 МБ)')
                        ->columnSpanFull(),
                ]),

            Section::make('Публикация')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Опубликовано')
                        ->default(false)
                        ->helperText('Отображать вакансию на сайте'),

                    DateTimePicker::make('published_at')
                        ->label('Дата публикации')
                        ->default(now())
                        ->helperText('Когда вакансия будет опубликована'),

                    DateTimePicker::make('expires_at')
                        ->label('Дата истечения')
                        ->helperText('Когда вакансия перестанет отображаться (опционально)'),

                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
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

                Tables\Columns\TextColumn::make('salary')
                    ->label('Зарплата')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('salary');
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

                Tables\Columns\TextColumn::make('location')
                    ->label('Местоположение')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('location');
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

                Tables\Columns\TextColumn::make('employment_type')
                    ->label('Тип занятости')
                    ->badge()
                    ->color('info')
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('employment_type');
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

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Истекает')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable()
                    ->color(fn ($state) => $state && $state < now() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Публикация')
                    ->placeholder('Все')
                    ->trueLabel('Только опубликованные')
                    ->falseLabel('Только черновики'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('publish')
                    ->label('Опубликовать')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_published' => true, 'published_at' => now()])))
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('unpublish')
                    ->label('Снять с публикации')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_published' => false])))
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
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}