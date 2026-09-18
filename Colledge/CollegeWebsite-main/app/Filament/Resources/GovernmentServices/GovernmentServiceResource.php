<?php

namespace App\Filament\Resources\GovernmentServices;

use App\Filament\Resources\GovernmentServices\Pages;
use App\Models\GovernmentService;
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

class GovernmentServiceResource extends Resource
{
    protected static ?string $model = GovernmentService::class;

    protected static ?string $navigationLabel = 'Государственные услуги';
    protected static ?string $modelLabel = 'Государственная услуга';
    protected static ?string $pluralModelLabel = 'Государственные услуги';
    
    protected static ?int $navigationSort = 15;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-document-text';
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

            Section::make('Название и описание')
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
                                                ->label('Название услуги на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Например: Предоставление общежития обучающимся')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_ru')
                                                ->label('Описание на русском')
                                                ->required()
                                                ->rows(3)
                                                ->placeholder('Детальное описание на русском языке')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Қызметтің қазақша атауы')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Оқушыларға жатақхана беру')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_kk')
                                                ->label('Қазақша сипаттама')
                                                ->rows(3)
                                                ->placeholder('Қазақ тіліндегі егжей-тегжейлі сипаттама')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Service name in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Providing dormitory for students')
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_en')
                                                ->label('Description in English')
                                                ->rows(3)
                                                ->placeholder('Detailed description in English')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Название услуги')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: Предоставление общежития обучающимся')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Полное описание услуги')
                            ->required()
                            ->rows(3)
                            ->placeholder('Детальное описание процедуры получения услуги')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Параметры услуги')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('params_translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->schema([
                                            TextInput::make('execution_time_ru')
                                                ->label('Срок выполнения')
                                                ->default('15 рабочих дней')
                                                ->maxLength(255)
                                                ->placeholder('Например: 10 рабочих дней'),
                                            
                                            TextInput::make('responsible_department_ru')
                                                ->label('Ответственный отдел')
                                                ->default('Деканат / Приемная комиссия')
                                                ->maxLength(255)
                                                ->placeholder('Например: Деканат'),
                                            
                                            Textarea::make('required_documents_ru')
                                                ->label('Необходимые документы')
                                                ->rows(3)
                                                ->placeholder('Список документов через запятую или с новой строки')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->schema([
                                            TextInput::make('execution_time_kk')
                                                ->label('Орындау мерзімі')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: 10 жұмыс күні'),
                                            
                                            TextInput::make('responsible_department_kk')
                                                ->label('Жауапты бөлім')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Деканат'),
                                            
                                            Textarea::make('required_documents_kk')
                                                ->label('Қажетті құжаттар')
                                                ->rows(3)
                                                ->placeholder('Құжаттар тізімі үтір немесе жаңа жол арқылы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->schema([
                                            TextInput::make('execution_time_en')
                                                ->label('Execution time')
                                                ->maxLength(255)
                                                ->placeholder('For example: 10 working days'),
                                            
                                            TextInput::make('responsible_department_en')
                                                ->label('Responsible department')
                                                ->maxLength(255)
                                                ->placeholder('For example: Dean\'s Office'),
                                            
                                            Textarea::make('required_documents_en')
                                                ->label('Required documents')
                                                ->rows(3)
                                                ->placeholder('List of documents separated by comma or new line')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('execution_time')
                            ->label('Срок выполнения')
                            ->default('15 рабочих дней')
                            ->maxLength(255)
                            ->placeholder('Например: 10 рабочих дней'),

                        TextInput::make('responsible_department')
                            ->label('Ответственный отдел')
                            ->default('Деканат / Приемная комиссия')
                            ->maxLength(255)
                            ->placeholder('Например: Деканат'),

                        Textarea::make('required_documents')
                            ->label('Необходимые документы')
                            ->rows(3)
                            ->placeholder('Список документов через запятую или с новой строки')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Бланк заявления')
                ->schema([
                    FileUpload::make('application_form_path')
                        ->label('PDF бланк заявления')
                        ->disk('public_files')
                        ->directory('services/application-forms')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->helperText('Загрузите PDF бланк заявления для скачивания (макс. 5 МБ, необязательно)')
                        ->columnSpanFull(),
                ]),

            Section::make('Дополнительные документы')
                ->schema([
                    Repeater::make('documents')
                        ->label('Документы')
                        ->relationship('documents')
                        ->schema([
                            TextInput::make('name')
                                ->label('Название документа')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Например: Регламент предоставления услуги'),

                            FileUpload::make('file_path')
                                ->label('PDF файл')
                                ->disk('public_files')
                                ->directory('services/documents')
                                ->acceptedFileTypes(['application/pdf'])
                                ->maxSize(10240)
                                ->required()
                                ->helperText('Макс. 10 МБ'),

                            Select::make('document_type')
                                ->label('Тип документа')
                                ->options([
                                    'info' => 'Информационный',
                                    'form' => 'Форма/Бланк',
                                    'regulation' => 'Регламент',
                                    'instruction' => 'Инструкция',
                                    'other' => 'Другое',
                                ])
                                ->default('info')
                                ->required(),

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
                        ->label('Активна (отображать на сайте)')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название услуги')
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

                Tables\Columns\TextColumn::make('execution_time')
                    ->label('Срок выполнения')
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('execution_time');
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

                Tables\Columns\TextColumn::make('responsible_department')
                    ->label('Ответственный отдел')
                    ->searchable()
                    ->toggleable()
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawData = $record->getRawOriginal('responsible_department');
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

                Tables\Columns\IconColumn::make('application_form_path')
                    ->label('Бланк')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
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

                Tables\Filters\SelectFilter::make('has_application_form')
                    ->label('Наличие бланка')
                    ->query(fn ($query, $state) => 
                        $state['value'] === true 
                            ? $query->whereNotNull('application_form_path')
                            : ($state['value'] === false ? $query->whereNull('application_form_path') : $query)
                    )
                    ->options([
                        true => 'Есть бланк',
                        false => 'Нет бланка',
                    ]),
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
            'index' => Pages\ListGovernmentServices::route('/'),
            'create' => Pages\CreateGovernmentService::route('/create'),
            'edit' => Pages\EditGovernmentService::route('/{record}/edit'),
        ];
    }
}