<?php

namespace App\Filament\Resources\Councils;

use App\Filament\Resources\Councils\Pages;
use App\Models\Council;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
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

class CouncilResource extends Resource
{
    protected static ?string $model = Council::class;

    protected static ?string $navigationLabel = 'Советы при колледже';
    protected static ?string $modelLabel = 'Совет';
    protected static ?string $pluralModelLabel = 'Советы';
    protected static ?int $navigationSort = 10;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationBadge(): ?string
    {
        return null;
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

            Section::make('Название и описание совета')
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
                                                ->label('Название совета на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Педагогический совет')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_ru')
                                                ->label('Описание на русском')
                                                ->required()
                                                ->rows(3)
                                                ->maxLength(1000)
                                                ->placeholder('Краткое описание функций и задач совета на русском')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Кеңестің қазақша атауы')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Педагогикалық кеңес')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_kk')
                                                ->label('Қазақша сипаттама')
                                                ->rows(3)
                                                ->maxLength(1000)
                                                ->placeholder('Қазақ тіліндегі кеңестің функциялары мен міндеттерінің қысқаша сипаттамасы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Council name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Pedagogical Council')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_en')
                                                ->label('Description in English')
                                                ->rows(3)
                                                ->maxLength(1000)
                                                ->placeholder('Brief description of council functions and tasks in English')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Название совета')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Педагогический совет')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000)
                            ->placeholder('Краткое описание функций и задач совета')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Визуальное оформление')
                ->schema([
                    Select::make('icon')
                        ->label('Иконка (Font Awesome)')
                        ->required()
                        ->options([
                            'fas fa-chalkboard-teacher' => 'Педагогический совет (учитель)',
                            'fas fa-book-open' => 'Методический совет (книга)',
                            'fas fa-hands-helping' => 'Попечительский совет (руки)',
                            'fas fa-balance-scale' => 'Совет по этике (весы)',
                            'fas fa-users' => 'Совет молодежи (люди)',
                            'fas fa-user-tie' => 'Деловой совет',
                            'fas fa-graduation-cap' => 'Академический совет',
                        ])
                        ->searchable()
                        ->default('fas fa-users'),
                ])->columns(1),

            Section::make('Детали совета')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('details_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('chairman_ru')
                                                ->label('Председатель')
                                                ->maxLength(255)
                                                ->placeholder('ФИО председателя совета'),
                                            
                                            TextInput::make('meeting_frequency_ru')
                                                ->label('Частота заседаний')
                                                ->default('1 раз в месяц')
                                                ->maxLength(255),
                                            
                                            TextInput::make('work_period_ru')
                                                ->label('Период работы')
                                                ->default('2023-2024 учебный год')
                                                ->maxLength(255),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('chairman_kk')
                                                ->label('Төраға')
                                                ->maxLength(255)
                                                ->placeholder('Кеңес төрағасының аты-жөні'),
                                            
                                            TextInput::make('meeting_frequency_kk')
                                                ->label('Жиналыс жиілігі')
                                                ->default('Айына 1 рет')
                                                ->maxLength(255),
                                            
                                            TextInput::make('work_period_kk')
                                                ->label('Жұмыс мерзімі')
                                                ->default('2023-2024 оқу жылы')
                                                ->maxLength(255),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('chairman_en')
                                                ->label('Chairman')
                                                ->maxLength(255)
                                                ->placeholder('Full name of the council chairman'),
                                            
                                            TextInput::make('meeting_frequency_en')
                                                ->label('Meeting frequency')
                                                ->default('Once a month')
                                                ->maxLength(255),
                                            
                                            TextInput::make('work_period_en')
                                                ->label('Work period')
                                                ->default('2023-2024 academic year')
                                                ->maxLength(255),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('chairman')
                            ->label('Председатель')
                            ->maxLength(255)
                            ->placeholder('ФИО председателя совета'),

                        TextInput::make('meeting_frequency')
                            ->label('Частота заседаний')
                            ->default('1 раз в месяц')
                            ->maxLength(255),

                        TextInput::make('work_period')
                            ->label('Период работы')
                            ->default('2023-2024 учебный год')
                            ->maxLength(255),
                    ];
                })->columns(3),

            Section::make('Контактная информация')
                ->schema([
                    TextInput::make('contact_email')
                        ->label('Email для связи')
                        ->email()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Section::make('Документы совета')
                ->schema([
                    Repeater::make('documents')
                        ->label('Документы')
                        ->relationship('documents')
                        ->schema([
                            TextInput::make('name')
                                ->label('Название документа')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Например: Положение о Педагогическом совете'),

                            FileUpload::make('file_path')
                                ->label('PDF файл')
                                ->disk('public_files')
                                ->directory('councils/documents')
                                ->acceptedFileTypes(['application/pdf'])
                                ->maxSize(10240)
                                ->required()
                                ->helperText('Макс. 10 МБ'),

                            TextInput::make('order')
                                ->label('Порядок')
                                ->numeric()
                                ->default(0)
                                ->helperText('Чем меньше число, тем выше в списке'),

                            Toggle::make('is_visible')
                                ->label('Видимый')
                                ->default(true),
                        ])
                        ->columns(2)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->addActionLabel('Добавить документ')
                        ->reorderable('order')
                        ->columnSpanFull(),
                ]),

            Section::make('Публикация')
                ->schema([
                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),

                    Toggle::make('is_active')
                        ->label('Активен (отображать на сайте)')
                        ->default(true),
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

                Tables\Columns\TextColumn::make('chairman')
                    ->label('Председатель')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('chairman');
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

                Tables\Columns\TextColumn::make('documents_count')
                    ->label('Документов')
                    ->counts('documents')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активность')
                    ->placeholder('Все')
                    ->trueLabel('Только активные')
                    ->falseLabel('Только неактивные'),
                    
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
                BulkAction::make('activate')
                    ->label('Активировать')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => $records->each->update(['is_active' => true]))
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('deactivate')
                    ->label('Деактивировать')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => $records->each->update(['is_active' => false]))
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
            'index' => Pages\ListCouncils::route('/'),
            'create' => Pages\CreateCouncil::route('/create'),
            'edit' => Pages\EditCouncil::route('/{record}/edit'),
        ];
    }
}