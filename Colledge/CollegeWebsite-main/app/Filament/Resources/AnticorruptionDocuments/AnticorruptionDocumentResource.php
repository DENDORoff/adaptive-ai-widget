<?php

namespace App\Filament\Resources\AnticorruptionDocuments;

use App\Filament\Resources\AnticorruptionDocuments\Pages;
use App\Models\AnticorruptionDocument;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components as FormComponents;
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
use Illuminate\Support\Facades\Storage;

class AnticorruptionDocumentResource extends Resource
{
    protected static ?string $model = AnticorruptionDocument::class;

    protected static ?string $navigationLabel = 'Противодействие коррупции';
    protected static ?string $modelLabel = 'Документ';
    protected static ?string $pluralModelLabel = 'Документы по коррупции';
    
    protected static ?int $navigationSort = 2;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-shield-check';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_published', true)->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основная информация')
                ->schema([
                    FormComponents\Toggle::make('is_multilang')
                        ->label('Многоязычный контент')
                        ->default(true)
                        ->live()
                        ->helperText('Включите для контента на нескольких языках')
                        ->columnSpanFull(),
                ]),

            Section::make('Название и описание документа')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            FormComponents\TextInput::make('title_ru')
                                                ->label('Название документа на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(function (callable $set, ?string $state) {
                                                    if (!empty($state)) {
                                                        $set('slug', Str::slug($state));
                                                    }
                                                }),

                                            FormComponents\Textarea::make('description_ru')
                                                ->label('Описание на русском')
                                                ->rows(3)
                                                ->helperText('Краткое описание документа')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            FormComponents\TextInput::make('title_kk')
                                                ->label('Құжаттың қазақша атауы')
                                                ->maxLength(255),

                                            FormComponents\Textarea::make('description_kk')
                                                ->label('Қазақша сипаттамасы')
                                                ->rows(3)
                                                ->helperText('Құжаттың қысқаша сипаттамасы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            FormComponents\TextInput::make('title_en')
                                                ->label('Document name in English')
                                                ->maxLength(255),

                                            FormComponents\Textarea::make('description_en')
                                                ->label('Description in English')
                                                ->rows(3)
                                                ->helperText('Brief description of the document')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        FormComponents\TextInput::make('title')
                            ->label('Название документа')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, ?string $state) {
                                if (!empty($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        FormComponents\Textarea::make('description')
                            ->label('Описание')
                            ->rows(3)
                            ->helperText('Краткое описание документа')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('URL и классификация')
                ->schema([
                    FormComponents\TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Автоматически генерируется из названия')
                        ->columnSpanFull(),

                    FormComponents\Select::make('type')
                        ->label('Тип')
                        ->options([
                            'document' => 'Документ по противодействию коррупции',
                            'information' => 'Перечень сведений',
                        ])
                        ->required()
                        ->helperText('Выберите раздел для размещения'),

                    FormComponents\Select::make('category')
                        ->label('Категория')
                        ->options([
                            'law' => 'Нормативный акт',
                            'report' => 'Отчет',
                            'info' => 'Информация',
                            'order' => 'Распоряжение',
                        ])
                        ->required()
                        ->helperText('Категория документа для иконки'),

                    FormComponents\DatePicker::make('document_date')
                        ->label('Дата документа')
                        ->helperText('Дата создания или публикации документа'),
                ])->columns(2),

            Section::make('PDF документ')
                ->schema([
                    FormComponents\FileUpload::make('pdf_file')
                        ->label('PDF файл')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required()
                        ->disk('public_files')
                        ->directory('anticorruption-documents')
                        ->maxSize(20480) // 20MB
                        ->helperText('Загрузите PDF файл (макс. 20 МБ)')
                        ->afterStateUpdated(function (callable $set, $state) {
                            if ($state) {
                                $path = Storage::disk('public_files')->path($state);
                                if (file_exists($path)) {
                                    $bytes = filesize($path);
                                    $set('file_size', self::formatBytes($bytes));
                                }
                            }
                        })
                        ->columnSpanFull(),
                ]),

            Section::make('Публикация')
                ->schema([
                    FormComponents\Toggle::make('is_published')
                        ->label('Опубликован')
                        ->default(true)
                        ->helperText('Отображать документ на сайте'),

                    FormComponents\TextInput::make('order')
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

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'document' => 'Документ',
                        'information' => 'Перечень сведений',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'document',
                        'success' => 'information',
                    ]),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Категория')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'law' => 'Норм. акт',
                        'report' => 'Отчет',
                        'info' => 'Информация',
                        'order' => 'Распоряжение',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'law',
                        'info' => 'report',
                        'success' => 'info',
                        'danger' => 'order',
                    ]),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\TextColumn::make('document_date')
                    ->label('Дата документа')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликован')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип')
                    ->options([
                        'document' => 'Документ',
                        'information' => 'Перечень сведений',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options([
                        'law' => 'Нормативный акт',
                        'report' => 'Отчет',
                        'info' => 'Информация',
                        'order' => 'Распоряжение',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Публикация')
                    ->placeholder('Все')
                    ->trueLabel('Только опубликованные')
                    ->falseLabel('Только черновики'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
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
            'index' => Pages\ListAnticorruptionDocuments::route('/'),
            'create' => Pages\CreateAnticorruptionDocument::route('/create'),
            'edit' => Pages\EditAnticorruptionDocument::route('/{record}/edit'),
        ];
    }

    private static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}