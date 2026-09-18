<?php

namespace App\Filament\Resources\Curators\Pages;

use App\Filament\Resources\Curators\CuratorResource;
use App\Imports\CuratorsImport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ListCurators extends ListRecords
{
    protected static string $resource = CuratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            
            Action::make('import')
                ->label('Импорт из Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->modalHeading('Импорт кураторов из Excel')
                ->modalDescription('Загрузите Excel файл. Формат: curator_name, group_name, specialt, students_count, room_number')
                ->form([
                    FileUpload::make('file')
                        ->label('Excel файл')
                        ->rules([
                            'required',
                            'file',
                            'mimes:xls,xlsx,xlsm',
                            'max:10240',
                        ])
                        ->required()
                        ->helperText('Файл должен содержать заголовки: curator_name, group_name, specialt и т.д.')
                        ->disk('public')
                        ->directory('temp-imports')
                        ->visibility('private'),
                ])
                ->action(function (array $data) {
                    try {
                        Log::info('=== CURATORS IMPORT START ===');
                        
                        $filePath = storage_path('app/public/' . $data['file']);
                        
                        if (!file_exists($filePath)) {
                            throw new \Exception('Файл не найден: ' . $filePath);
                        }
                        
                        // Делаем импорт
                        $import = new CuratorsImport();
                        Excel::import($import, $filePath);
                        
                        // Получаем результаты
                        $results = $import->getResults();
                        $imported = $results['imported'] ?? 0;
                        $updated = $results['updated'] ?? 0;
                        $errors = $results['errors'] ?? [];
                        
                        Log::info('Import results:', $results);
                        
                        // Удаляем файл
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        
                        // Формируем сообщение
                        $message = "Импорт кураторов завершен!\n";
                        $message .= "Импортировано: <strong>{$imported}</strong> кураторов\n";
                        $message .= "Обновлено: <strong>{$updated}</strong> кураторов\n";
                        
                        if (!empty($errors)) {
                            $errorRows = array_unique(array_column($errors, 'row'));
                            sort($errorRows);
                            
                            $message .= "\n<strong>Ошибки в строках:</strong> " . implode(', ', $errorRows);
                            
                            // Показываем детали первых 3 ошибок
                            $errorCount = 0;
                            foreach ($errors as $error) {
                                if ($errorCount >= 3) break;
                                
                                $row = $error['row'] ?? '?';
                                $errorMsg = $error['error'] ?? 'Неизвестная ошибка';
                                
                                $message .= "\n<strong>Строка {$row}:</strong> {$errorMsg}";
                                $errorCount++;
                            }
                            
                            if (count($errors) > 3) {
                                $message .= "\n... и еще " . (count($errors) - 3) . " ошибок";
                            }
                        }
                        
                        if (!empty($errors)) {
                            Notification::make()
                                ->title('Импорт с ошибками')
                                ->warning()
                                ->body($message)
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Импорт успешно завершен!')
                                ->success()
                                ->body($message)
                                ->send();
                        }
                        
                        $this->refresh();
                            
                    } catch (\Exception $e) {
                        Log::error('Import error: ' . $e->getMessage());
                        
                        if (isset($filePath) && file_exists($filePath)) {
                            unlink($filePath);
                        }
                        
                        Notification::make()
                            ->title('Ошибка импорта')
                            ->danger()
                            ->body('Произошла ошибка: ' . $e->getMessage())
                            ->send();
                    }
                })
                ->modalSubmitActionLabel('Импортировать')
                ->modalCancelActionLabel('Отмена'),
                
            Action::make('download_template')
                ->label('Скачать шаблон')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->action(function () {
                    // Создаем шаблон
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    
                    // Заголовки для одноязычного формата
                    $headers = [
                        'curator_name',
                        'group_name', 
                        'specialt',
                        'students_count',
                        'room_number',
                        'curator_email',
                        'curator_phone',
                        'course',
                        'curator_position',
                        'consultation_schedule',
                        'additional_info'
                    ];
                    
                    foreach ($headers as $index => $header) {
                        $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
                    }
                    
                    // Пример данных
                    $exampleData = [
                        'Иванов Иван Иванович',
                        'ИС-21-1',
                        'Информационные системы и программирование',
                        '25',
                        '305',
                        'ivanov@example.com',
                        '+7 777 123 45 67',
                        '3',
                        'Преподаватель информатики',
                        'Понедельник 14:00-16:00',
                        'Дополнительная информация о группе'
                    ];
                    
                    foreach ($exampleData as $index => $data) {
                        $sheet->setCellValueByColumnAndRow($index + 1, 2, $data);
                    }
                    
                    // Сохраняем временный файл
                    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                    $tempPath = storage_path('app/temp_curators_template.xlsx');
                    $writer->save($tempPath);
                    
                    return response()->download(
                        $tempPath,
                        'curators_import_template.xlsx'
                    )->deleteFileAfterSend(true);
                })
                ->modalSubmitActionLabel('Скачать')
                ->modalCancelActionLabel('Отмена'),
        ];
    }
}