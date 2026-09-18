<?php

namespace App\Filament\Actions;

use App\Models\News;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportNewsFromJsonAction
{
    public static function make()
    {
        return Action::make('importJson')
            ->label('Импорт из JSON')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->form([
                FileUpload::make('json_file')
                    ->label('JSON файл с новостями')
                    ->acceptedFileTypes(['application/json'])
                    ->required()
                    ->helperText('Загрузите JSON файл с новостями для импорта')
                    ->disk('public') 
                    ->directory('temp') 
                    ->visibility('public')
                    ->preserveFilenames()
                    ->maxSize(10240), 
            ])
            ->action(function (array $data) {
                try {
                    \Log::info('=== НАЧАЛО ИМПОРТА ===');
                    
                    $filePath = storage_path('app/public/' . $data['json_file']);
                    
                    \Log::info('Ищем файл: ' . $filePath);
                    
                    if (!file_exists($filePath)) {
                        \Log::error('Файл не найден по пути: ' . $filePath);
                        
                        $altPath = public_path('storage/' . $data['json_file']);
                        if (file_exists($altPath)) {
                            $filePath = $altPath;
                            \Log::info('Найден по альтернативному пути: ' . $filePath);
                        } else {
                            Notification::make()
                                ->title('Файл не найден')
                                ->body('Загруженный файл не найден на сервере.')
                                ->danger()
                                ->send();
                            return;
                        }
                    }
                    
                    \Log::info('Файл найден, размер: ' . filesize($filePath) . ' байт');
                    
                    $jsonContent = file_get_contents($filePath);
                    
                    if (empty($jsonContent)) {
                        Notification::make()
                            ->title('Ошибка')
                            ->body('Файл пустой')
                            ->danger()
                            ->send();
                        return;
                    }
                    

                    $newsData = json_decode($jsonContent, true);
                    
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        Notification::make()
                            ->title('Ошибка формата JSON')
                            ->body('Ошибка: ' . json_last_error_msg())
                            ->danger()
                            ->send();
                        return;
                    }
                    
                    if (empty($newsData) || !is_array($newsData)) {
                        Notification::make()
                            ->title('Ошибка')
                            ->body('JSON файл должен содержать массив новостей')
                            ->danger()
                            ->send();
                        return;
                    }
                    
                    \Log::info('Найдено новостей: ' . count($newsData));
                    
                    $imported = 0;
                    $skipped = 0;
                    $errors = [];
                    
                    foreach ($newsData as $index => $item) {
                        try {

                            if (empty($item['title'])) {
                                \Log::warning('Пропущена запись ' . $index . ': нет заголовка');
                                continue;
                            }
                            
                            $slug = Str::slug($item['title']);
                            

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
                                

                                if (!empty($item['images'][0])) {
                                    $mainImage = self::processImage($item['images'][0], $item['year'] ?? date('Y'));
                                    \Log::info('Главное изображение: ' . ($mainImage ? 'скопировано' : 'не найдено'));
                                }
                                

                                if (count($item['images']) > 1) {
                                    for ($i = 1; $i < count($item['images']); $i++) {
                                        if (!empty($item['images'][$i])) {
                                            $savedPath = self::processImage($item['images'][$i], $item['year'] ?? date('Y'));
                                            if ($savedPath) {
                                                $gallery[] = $savedPath;
                                            }
                                        }
                                    }
                                    \Log::info('Изображений в галерее: ' . count($gallery));
                                }
                            }

                            News::create([
                                'title' => $item['title'],
                                'slug' => $slug,
                                'excerpt' => Str::limit($item['text'] ?? '', 200),
                                'content' => nl2br($item['text'] ?? ''),
                                'image' => $mainImage,
                                'gallery' => $gallery,
                                'is_published' => true,
                                'is_featured' => $item['featured'] ?? false,
                                'published_at' => isset($item['year']) 
                                    ? now()->setYear($item['year'])->startOfYear()
                                    : now(),
                            ]);
                            
                            $imported++;
                            \Log::info('Успешно импортировано: ' . $item['title']);
                            
                        } catch (\Exception $e) {
                            $errorMsg = "Ошибка в записи '{$item['title']}': " . $e->getMessage();
                            $errors[] = $errorMsg;
                            \Log::error($errorMsg);
                            \Log::error($e->getTraceAsString());
                        }
                    }
                    

                    try {
                        Storage::disk('public')->delete($data['json_file']);
                        \Log::info('Временный файл удален');
                    } catch (\Exception $e) {
                        \Log::warning('Не удалось удалить временный файл: ' . $e->getMessage());
                    }
                    

                    if ($imported > 0) {
                        Notification::make()
                            ->title('Импорт завершен успешно!')
                            ->body("✅ Импортировано: {$imported} новостей\n⏭️ Пропущено (дубликаты): {$skipped}")
                            ->success()
                            ->duration(5000)
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Нет данных для импорта')
                            ->body('Не удалось импортировать ни одной новости. Проверьте формат файла.')
                            ->warning()
                            ->send();
                    }
                    
                    if (!empty($errors)) {
                        Notification::make()
                            ->title('Были ошибки при импорте')
                            ->body(count($errors) . ' новостей не импортированы. Проверьте логи.')
                            ->warning()
                            ->send();
                    }
                    
                    \Log::info('=== ИМПОРТ ЗАВЕРШЕН ===');
                    
                } catch (\Exception $e) {
                    \Log::error('КРИТИЧЕСКАЯ ОШИБКА ИМПОРТА: ' . $e->getMessage());
                    \Log::error($e->getTraceAsString());
                    
                    Notification::make()
                        ->title('Критическая ошибка импорта')
                        ->body('Ошибка: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalHeading('Импорт новостей из JSON')
            ->modalDescription('Загрузите JSON файл. Изображения будут скопированы из public/uploads/news/')
            ->modalSubmitActionLabel('Импортировать')
            ->modalWidth('lg')
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-arrow-down-tray');
    }
    

    protected static function processImage(string $imageUrl, string $year): ?string
    {
        try {

            $fileName = basename($imageUrl);
            

            preg_match('/\/(\d{4})\//', $imageUrl, $matches);
            $urlYear = $matches[1] ?? $year;
            
            \Log::info("Обработка изображения: {$fileName}, год из URL: {$urlYear}, год из данных: {$year}");
            

            $sourcePath = public_path("uploads/news/{$urlYear}/{$fileName}");
            

            if (!file_exists($sourcePath)) {
                $sourcePath = public_path("uploads/news/{$year}/{$fileName}");
                \Log::info("Пробуем альтернативный путь: " . $sourcePath);
            }
            

            if (!file_exists($sourcePath)) {
                \Log::warning("Изображение не найдено: {$fileName}");
                \Log::warning("Искали в: public/uploads/news/{$urlYear}/ и public/uploads/news/{$year}/");
                return null;
            }
            

            $destinationDir = storage_path("app/public/news/{$urlYear}");
            

            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
                \Log::info("Создана директория: {$destinationDir}");
            }
            
            $destinationPath = "news/{$urlYear}/{$fileName}";
            $destinationFullPath = storage_path("app/public/{$destinationPath}");
            

            if (copy($sourcePath, $destinationFullPath)) {
                \Log::info("✅ Изображение скопировано: {$fileName} -> {$destinationPath}");
                return $destinationPath;
            } else {
                \Log::error("❌ Не удалось скопировать изображение: {$fileName}");
                return null;
            }
            
        } catch (\Exception $e) {
            \Log::error("Ошибка обработки изображения {$fileName}: " . $e->getMessage());
            return null;
        }
    }
}