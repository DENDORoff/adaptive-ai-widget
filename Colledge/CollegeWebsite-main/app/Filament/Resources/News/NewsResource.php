<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages;
use App\Models\News;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationLabel = 'Новости';
    protected static ?string $modelLabel = 'Новость';
    protected static ?string $pluralModelLabel = 'Новости';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-newspaper';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->schema([
                        Toggle::make('is_multilang')
                            ->label('Многоязычный контент')
                            ->default(true)
                            ->live()
                            ->helperText('Включите для контента на нескольких языках')
                            ->columnSpanFull(),
                        
                        TextInput::make('slug')
                            ->label('URL (slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Автоматически генерируется из русского заголовка')
                            ->columnSpanFull(),
                    ]),

                Section::make('Заголовок')
                    ->schema(function (Get $get) {
                        $isMultilang = $get('is_multilang');
                        
                        if ($isMultilang) {
                            return [
                                Tabs::make('title_translations')
                                    ->tabs([
                                        Tab::make('Русский')
                                            ->icon('heroicon-o-language')
                                            ->schema([
                                                TextInput::make('title_ru')
                                                    ->label('Заголовок на русском')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (?string $state, Set $set) {
                                                        if ($state) {
                                                            $set('slug', Str::slug($state));
                                                        }
                                                    }),
                                            ]),
                                        
                                        Tab::make('Қазақша')
                                            ->icon('heroicon-o-language')
                                            ->schema([
                                                TextInput::make('title_kk')
                                                    ->label('Қазақша тақырып')
                                                    ->maxLength(255),
                                            ]),
                                        
                                        Tab::make('English')
                                            ->icon('heroicon-o-language')
                                            ->schema([
                                                TextInput::make('title_en')
                                                    ->label('Title in English')
                                                    ->maxLength(255),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        return [
                            TextInput::make('title')
                                ->label('Заголовок')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (?string $state, Set $set) {
                                    if ($state) {
                                        $set('slug', Str::slug($state));
                                    }
                                })
                                ->columnSpanFull(),
                        ];
                    }),

                Section::make('Краткое описание')
                    ->schema(function (Get $get) {
                        $isMultilang = $get('is_multilang');
                        
                        if ($isMultilang) {
                            return [
                                Tabs::make('excerpt_translations')
                                    ->tabs([
                                        Tab::make('Русский')
                                            ->schema([
                                                Textarea::make('excerpt_ru')
                                                    ->label('Краткое описание на русском')
                                                    ->rows(3),
                                            ]),
                                        
                                        Tab::make('Қазақша')
                                            ->schema([
                                                Textarea::make('excerpt_kk')
                                                    ->label('Қысқаша сипаттама')
                                                    ->rows(3),
                                            ]),
                                        
                                        Tab::make('English')
                                            ->schema([
                                                Textarea::make('excerpt_en')
                                                    ->label('Short description in English')
                                                    ->rows(3),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        return [
                            Textarea::make('excerpt')
                                ->label('Краткое описание')
                                ->rows(3)
                                ->columnSpanFull(),
                        ];
                    }),

                Section::make('Полный контент')
                    ->schema(function (Get $get) {
                        $isMultilang = $get('is_multilang');
                        
                        if ($isMultilang) {
                            return [
                                Tabs::make('content_translations')
                                    ->tabs([
                                        Tab::make('Русский')
                                            ->schema([
                                                RichEditor::make('content_ru')
                                                    ->label('Контент на русском')
                                                    ->required()
                                                    ->toolbarButtons([
                                                        'bold', 'italic', 'underline', 'strike',
                                                        'link', 'bulletList', 'orderedList',
                                                        'blockquote', 'codeBlock', 'h2', 'h3',
                                                    ]),
                                            ]),
                                        
                                        Tab::make('Қазақша')
                                            ->schema([
                                                RichEditor::make('content_kk')
                                                    ->label('Қазақша мазмұн')
                                                    ->toolbarButtons([
                                                        'bold', 'italic', 'underline', 'strike',
                                                        'link', 'bulletList', 'orderedList',
                                                        'blockquote', 'codeBlock', 'h2', 'h3',
                                                    ]),
                                            ]),
                                        
                                        Tab::make('English')
                                            ->schema([
                                                RichEditor::make('content_en')
                                                    ->label('Content in English')
                                                    ->toolbarButtons([
                                                        'bold', 'italic', 'underline', 'strike',
                                                        'link', 'bulletList', 'orderedList',
                                                        'blockquote', 'codeBlock', 'h2', 'h3',
                                                    ]),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        return [
                            RichEditor::make('content')
                                ->label('Полное содержание')
                                ->required()
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline', 'strike',
                                    'link', 'bulletList', 'orderedList',
                                    'blockquote', 'codeBlock', 'h2', 'h3',
                                ]),
                        ];
                    }),

                Section::make('Изображения')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Главное изображение')
                            ->image()
                            ->disk('public')
                            ->directory('news')
                            ->helperText('Для превью'),
                        
                        FileUpload::make('gallery')
                            ->label('Галерея')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('news/gallery')
                            ->reorderable()
                            ->helperText('Для карусели'),
                    ])->columns(2),

                Section::make('Публикация')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        
                        Toggle::make('is_featured')
                            ->label('На главной'),
                        
                        DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->default(now()),
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
                    ->disk('public'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50)
                    ->formatStateUsing(function ($state, $record) {
                        return $record->getTranslatedTitle();
                    }),
                
                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->tooltip('Многоязычный'),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('На главной')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликовано'),
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->label('Удалить выбранные')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->headerActions([
                Action::make('importJson')
                    ->label('Импорт из JSON')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->modalHeading('Импорт новостей из JSON')
                    ->modalDescription('Загрузите JSON файл. Изображения будут скопированы из public/uploads/news/')
                    ->modalSubmitActionLabel('Импортировать')
                    ->modalWidth('lg')
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-arrow-down-tray')
                    ->form([
                        FileUpload::make('json_file')
                            ->label('JSON файл с новостями')
                            ->acceptedFileTypes(['application/json'])
                            ->required()
                            ->helperText('Загрузите JSON файл с новостями для импорта')
                            ->disk('local')
                            ->directory('news_json_import')
                            ->preserveFilenames()
                            ->maxSize(51200) // Увеличили до 50 МБ
                            ->acceptedFileTypes(['application/json', 'text/json', 'json'])
                            ->rules([
                                'max:51200', // 50 МБ
                            ]),
                    ])
                    ->action(function (array $data) {
                        try {
                            \Log::info('=== НАЧАЛО ИМПОРТА ===');
                            
                            $fileName = basename($data['json_file']);
                            $filePath = storage_path('app/news_json_import/' . $fileName);
                            
                            if (!file_exists($filePath)) {
                                \Log::error('Файл не найден: ' . $filePath);
                                Notification::make()
                                    ->title('Файл не найден')
                                    ->body('Путь: ' . $filePath . '. Проверьте папку storage/app/news_json_import/')
                                    ->danger()
                                    ->send();
                                return;
                            }
                            
                            // Показываем уведомление о начале импорта
                            Notification::make()
                                ->title('Начинаем импорт...')
                                ->body('Обработка большого файла может занять некоторое время.')
                                ->warning()
                                ->send();
                            
                            // Потоковое чтение JSON для больших файлов
                            $imported = 0;
                            $skipped = 0;
                            $errors = [];
                            $batchSize = 50; // Количество новостей за одну итерацию
                            $processedCount = 0;
                            
                            // Читаем файл частями
                            $jsonContent = file_get_contents($filePath);
                            
                            if (!$jsonContent) {
                                Notification::make()
                                    ->title('Ошибка чтения файла')
                                    ->body('Не удалось прочитать JSON файл')
                                    ->danger()
                                    ->send();
                                return;
                            }
                            
                            // Декодируем JSON
                            $newsData = json_decode($jsonContent, true);
                            
                            if (json_last_error() !== JSON_ERROR_NONE) {
                                Notification::make()
                                    ->title('Ошибка JSON')
                                    ->body(json_last_error_msg())
                                    ->danger()
                                    ->send();
                                return;
                            }
                            
                            if (empty($newsData) || !is_array($newsData)) {
                                Notification::make()
                                    ->title('Нет данных')
                                    ->body('JSON файл пуст')
                                    ->warning()
                                    ->send();
                                return;
                            }
                            
                            \Log::info('Найдено новостей: ' . count($newsData));
                            
                            // Обрабатываем новости батчами
                            $totalNews = count($newsData);
                            
                            foreach (array_chunk($newsData, $batchSize) as $batchIndex => $batch) {
                                \Log::info("Обработка батча {$batchIndex}: " . count($batch) . " записей");
                                
                                foreach ($batch as $index => $item) {
                                    $actualIndex = ($batchIndex * $batchSize) + $index;
                                    $processedCount++;
                                    
                                    try {
                                        // Показываем прогресс каждые 50 записей
                                        if ($processedCount % 50 === 0) {
                                            \Log::info("Обработано: {$processedCount}/{$totalNews}");
                                        }
                                        
                                        if (empty($item['title'])) {
                                            \Log::warning('Пропущена запись ' . $actualIndex . ': нет заголовка');
                                            continue;
                                        }
                                        
                                        $slug = Str::slug($item['title']) . '-' . uniqid();
                                        $existing = News::where('slug', $slug)->first();
                                        
                                        if ($existing) {
                                            $skipped++;
                                            \Log::info('Пропущен дубликат: ' . $item['title']);
                                            continue;
                                        }
                                        
                                        $mainImage = null;
                                        $gallery = [];
                                        
                                        if (!empty($item['images']) && is_array($item['images'])) {
                                            \Log::info('Обработка изображений для: ' . $item['title']);
                                            
                                            foreach ($item['images'] as $imageIndex => $imagePath) {
                                                try {
                                                    \Log::info("Исходный путь из JSON: {$imagePath}");
                                                    
                                                    // Получаем фактический путь к исходному файлу
                                                    $actualSourcePath = self::getActualSourcePath($imagePath);
                                                    
                                                    if ($actualSourcePath && file_exists($actualSourcePath)) {
                                                        \Log::info("Файл найден: {$actualSourcePath}");
                                                        
                                                        // Сохраняем изображение
                                                        $savedPath = self::saveImageToStorage($actualSourcePath);
                                                        
                                                        if ($savedPath) {
                                                            if ($imageIndex === 0) {
                                                                $mainImage = $savedPath;
                                                            } else {
                                                                $gallery[] = $savedPath;
                                                            }
                                                        }
                                                    } else {
                                                        \Log::warning("Изображение не найдено: {$actualSourcePath}");
                                                    }
                                                } catch (\Exception $e) {
                                                    \Log::warning('Ошибка обработки изображения ' . $imageIndex . ': ' . $e->getMessage());
                                                }
                                            }
                                        }
                                        
                                        // ИСПРАВЛЕННЫЙ КОД: Правильная обработка даты
                                        $publishedDate = now();
                                        
                                        if (!empty($item['year'])) {
                                            $year = intval($item['year']);
                                            if ($year >= 2000 && $year <= date('Y')) {
                                                // Создаем дату с указанным годом
                                                $publishedDate = Carbon::createFromDate($year, 1, 1);
                                            }
                                        }
                                        
                                        // Проверяем, есть ли дата публикации в другом поле
                                        if (!empty($item['published_at'])) {
                                            try {
                                                $publishedDate = Carbon::parse($item['published_at']);
                                            } catch (\Exception $e) {
                                                \Log::warning('Не удалось распарсить дату: ' . $item['published_at']);
                                            }
                                        }
                                        
                                        // Для импортированных новостей создаем многоязычную структуру
                                        $titleJson = json_encode([
                                            'ru' => $item['title'],
                                            'kk' => '',
                                            'en' => '',
                                        ], JSON_UNESCAPED_UNICODE);
                                        
                                        $excerptJson = json_encode([
                                            'ru' => Str::limit($item['text'] ?? '', 200),
                                            'kk' => '',
                                            'en' => '',
                                        ], JSON_UNESCAPED_UNICODE);
                                        
                                        $contentJson = json_encode([
                                            'ru' => self::formatContent($item['text'] ?? ''),
                                            'kk' => '',
                                            'en' => '',
                                        ], JSON_UNESCAPED_UNICODE);
                                        
                                        News::create([
                                            'title' => $titleJson,
                                            'slug' => $slug,
                                            'excerpt' => $excerptJson,
                                            'content' => $contentJson,
                                            'image' => $mainImage,
                                            'gallery' => $gallery,
                                            'is_published' => true,
                                            'is_featured' => false,
                                            'is_multilang' => true, // Импортированные новости всегда многоязычные
                                            'published_at' => $publishedDate,
                                        ]);
                                        
                                        $imported++;
                                        
                                    } catch (\Exception $e) {
                                        $errorMsg = "Ошибка '{$item['title']}': " . $e->getMessage();
                                        $errors[] = $errorMsg;
                                        \Log::error($errorMsg);
                                        \Log::error($e->getTraceAsString());
                                    }
                                }
                                
                                // Освобождаем память после каждого батча
                                gc_collect_cycles();
                            }
                            
                            // Удаляем временный файл
                            @unlink($filePath);
                            
                            // Показываем результат
                            if ($imported > 0) {
                                Notification::make()
                                    ->title('Импорт завершен успешно!')
                                    ->body("✅ Импортировано: {$imported} новостей\n⏭️ Пропущено (дубликаты): {$skipped}\n❌ Ошибок: " . count($errors))
                                    ->success()
                                    ->duration(10000)
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Нет данных для импорта')
                                    ->body('Не удалось импортировать ни одной новости')
                                    ->warning()
                                    ->send();
                            }
                            
                            // Логируем ошибки, если они были
                            if (!empty($errors)) {
                                \Log::warning('Были ошибки импорта: ' . implode(', ', array_slice($errors, 0, 10)));
                            }
                            
                            \Log::info('=== ИМПОРТ ЗАВЕРШЕН ===');
                            
                        } catch (\Exception $e) {
                            \Log::error('Критическая ошибка импорта: ' . $e->getMessage());
                            \Log::error($e->getTraceAsString());
                            
                            Notification::make()
                                ->title('Критическая ошибка импорта')
                                ->body('Ошибка: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                
                CreateAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }
    
    /**
     * Получает фактический путь к исходному файлу изображения
     */
    private static function getActualSourcePath(string $imagePath): ?string
    {
        \Log::info("Получение пути для: {$imagePath}");
        
        $imagePath = trim($imagePath);
        
        // Если путь начинается с "news/", убираем его
        if (strpos($imagePath, 'news/') === 0) {
            $imagePath = substr($imagePath, 5);
        }
        
        // Если путь начинается с "/", убираем его
        if (strpos($imagePath, '/') === 0) {
            $imagePath = substr($imagePath, 1);
        }
        
        \Log::info("Очищенный путь: {$imagePath}");
        
        // Теперь $imagePath должен быть в формате "2019/KUZK6584.JPG"
        $sourcePath = public_path("uploads/news/{$imagePath}");
        
        \Log::info("Полный путь поиска: {$sourcePath}");
        
        if (file_exists($sourcePath)) {
            return $sourcePath;
        }
        
        // Альтернативный путь поиска
        $fileName = basename($imagePath);
        $year = dirname($imagePath);
        if ($year === '.') {
            $year = '2019';
        }
        
        $alternativePath = public_path("uploads/news/{$year}/{$fileName}");
        \Log::info("Альтернативный путь поиска: {$alternativePath}");
        
        if (file_exists($alternativePath)) {
            return $alternativePath;
        }
        
        return null;
    }
    
    /**
     * Сохраняет изображение в хранилище
     */
    private static function saveImageToStorage(string $sourcePath): ?string
    {
        try {
            $fileName = basename($sourcePath);
            
            $year = date('Y');
            preg_match('/(\d{4})\//', $sourcePath, $matches);
            if (!empty($matches[1])) {
                $year = $matches[1];
            }
            
            $destinationDir = storage_path("app/public/news/{$year}");
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            
            $destinationPath = "news/{$year}/{$fileName}";
            $destinationFullPath = storage_path("app/public/{$destinationPath}");
            
            if (copy($sourcePath, $destinationFullPath)) {
                \Log::info("Изображение сохранено: {$destinationPath}");
                return $destinationPath;
            } else {
                \Log::warning("Не удалось скопировать изображение: {$sourcePath}");
                return null;
            }
            
        } catch (\Exception $e) {
            \Log::error("Ошибка сохранения изображения {$sourcePath}: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Форматирует контент
     */
    private static function formatContent(string $text): string
    {
        $text = str_replace('\r\n', "\n", $text);
        $text = str_replace('\\r\\n', "\n", $text);
        
        $paragraphs = explode("\n\n", $text);
        $formatted = '';
        
        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if (!empty($paragraph)) {
                $formatted .= '<p>' . nl2br(e($paragraph)) . '</p>';
            }
        }
        
        return $formatted;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}