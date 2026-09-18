<?php

namespace App\Filament\Resources\NormativeDocuments;

use App\Filament\Resources\NormativeDocuments\Pages;
use App\Models\NormativeDocument;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Support\Facades\Storage;

class NormativeDocumentsResource extends Resource
{
    protected static ?string $model = NormativeDocument::class;

    protected static ?string $navigationLabel = 'Нормативные документы';
    protected static ?string $modelLabel = 'Нормативный документ';
    protected static ?string $pluralModelLabel = 'Нормативные документы';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-document-text';
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
                                            TextInput::make('title_ru')
                                                ->label('Название документа на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(function (callable $set, ?string $state) {
                                                    // Генерируем slug из названия
                                                    $slug = Str::slug($state);
                                                    $set('slug', $slug);
                                                    
                                                    // Генерируем document_id из названия
                                                    $documentId = Str::snake($state);
                                                    $set('document_id', $documentId);
                                                })
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_ru')
                                                ->label('Описание на русском')
                                                ->required()
                                                ->rows(4)
                                                ->helperText('Краткое описание содержания документа')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Құжаттың қазақша атауы')
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_kk')
                                                ->label('Қазақша сипаттама')
                                                ->rows(4)
                                                ->helperText('Құжат мазмұнының қысқаша сипаттамасы')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Document title in English')
                                                ->maxLength(255)
                                                ->live(onBlur: true)
                                                ->columnSpanFull(),
                                            
                                            Textarea::make('description_en')
                                                ->label('Description in English')
                                                ->rows(4)
                                                ->helperText('Brief description of the document content')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Название документа')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, ?string $state) {
                                // Генерируем slug из названия
                                $slug = Str::slug($state);
                                $set('slug', $slug);
                                
                                // Генерируем document_id из названия
                                $documentId = Str::snake($state);
                                $set('document_id', $documentId);
                            })
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание документа')
                            ->required()
                            ->rows(4)
                            ->helperText('Краткое описание содержания документа')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Идентификаторы')
                ->schema([
                    TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Автоматически генерируется из названия'),

                    TextInput::make('document_id')
                        ->label('ID документа')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true)
                        ->helperText('Автоматически генерируется из названия')
                        ->disabled()
                        ->dehydrated(),
                ])->columns(2),

            Section::make('Детали документа')
                ->schema([
                    TextInput::make('file_size')
                        ->label('Размер файла')
                        ->placeholder('Автоматически определяется')
                        ->maxLength(50),

                    TextInput::make('pages')
                        ->label('Количество страниц')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->minValue(1),
                ])->columns(2),

            Section::make('PDF документ')
                ->schema([
                    FileUpload::make('pdf_file')
                        ->label('PDF файл')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required()
                        ->disk('public_files')
                        ->directory('normative-documents')
                        ->maxSize(51200)
                        ->helperText('Загрузите PDF файл (макс. 50 МБ)')
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
                    Toggle::make('is_published')
                        ->label('Опубликовано')
                        ->default(true)
                        ->helperText('Отображать документ на сайте'),

                    DateTimePicker::make('published_at')
                        ->label('Дата публикации')
                        ->default(now())
                        ->helperText('Когда документ будет опубликован'),

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
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

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

                Tables\Columns\TextColumn::make('document_id')
                    ->label('ID документа')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Размер')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pages')
                    ->label('Страниц')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->action(fn (Collection $records) => 
                        $records->each(fn ($record) => $record->update(['is_published' => true, 'published_at' => now()]))
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('unpublish')
                    ->label('Снять с публикации')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => 
                        $records->each(fn ($record) => $record->update(['is_published' => false]))
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
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNormativeDocuments::route('/'),
            'create' => Pages\CreateNormativeDocuments::route('/create'),
            'edit' => Pages\EditNormativeDocuments::route('/{record}/edit'),
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