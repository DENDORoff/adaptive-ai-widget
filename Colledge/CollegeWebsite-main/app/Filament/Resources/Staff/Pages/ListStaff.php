<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\StaffResource;
use App\Imports\StaffImport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            
            Action::make('import')
                ->label('Импорт из Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->modalHeading('Импорт сотрудников из Excel')
                ->modalDescription('Загрузите Excel файл. ВАЖНО: Первая строка должна содержать заголовки колонок.')
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
                        ->helperText('Файл должен содержать колонки: fio_polnostyu, zanimaemaa_dolznost и другие')
                        ->disk('public')
                        ->directory('temp-imports')
                        ->visibility('private'),
                ])
                ->action(function (array $data) {
                    try {
                        Log::info('=== IMPORT START ===');
                        
                        $filePath = storage_path('app/public/' . $data['file']);
                        
                        if (!file_exists($filePath)) {
                            throw new \Exception('Файл не найден: ' . $filePath);
                        }
                        
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                        $worksheet = $spreadsheet->getActiveSheet();
                        
                        $headers = [];
                        for ($col = 1; $col <= 20; $col++) {
                            $cellValue = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                            if (!empty($cellValue)) {
                                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                                $headers[$colLetter] = $cellValue;
                            }
                        }
                        
                        Log::info('Excel headers found:', $headers);
                        

                        $headerMessage = "Найдены заголовки в файле:\n";
                        foreach ($headers as $col => $value) {
                            $headerMessage .= "{$col}: {$value}\n";
                        }
                        
                        Notification::make()
                            ->title('Анализ файла')
                            ->info()
                            ->body($headerMessage)
                            ->send();


                        $import = new StaffImport();
                        Excel::import($import, $filePath);
                        

                        $results = $import->getResults();
                        $imported = $results['imported'] ?? 0;
                        $updated = $results['updated'] ?? 0;
                        $errors = $results['errors'] ?? [];
                        
                        Log::info('Import results:', $results);
                        

                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        

                        $message = "Импорт завершен!\n";
                        $message .= "Импортировано: <strong>{$imported}</strong> сотрудников\n";
                        $message .= "Обновлено: <strong>{$updated}</strong> сотрудников\n";
                        
                        if (!empty($errors)) {
                            $errorRows = array_unique(array_column($errors, 'row'));
                            sort($errorRows);
                            
                            $message .= "\n<strong>Ошибки в строках:</strong> " . implode(', ', $errorRows);
                            

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

                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    

                    $headers = [
                        '№',
                        'fio_polnostyu',
                        'zanimaemaa_dolznost',
                        'obrazovanie_god_okoncania',
                        'specialnost_po_diplomu',
                        'kakoi_predmet_disciplinu_vedet',
                        'staz_raboty_obsii',
                        'staz_raboty_pedagogiceskii',
                        'kategoria',
                        'nagrady',
                        'kursy_povysenia_kvalifikacii',
                        'email'
                    ];
                    
                    foreach ($headers as $index => $header) {
                        $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
                    }
                    

                    $exampleData = [
                        '1',
                        'Иванов Иван Иванович',
                        'Преподаватель информатики',
                        'Высшее, КазНУ им. Аль-Фараби, 2010',
                        'Программное обеспечение вычислительной техники',
                        'Программирование, Базы данных',
                        '15 лет',
                        '10 лет',
                        'Высшая',
                        'Почетная грамота МОН РК, 2020',
                        'Курсы "Современные технологии обучения", 2023',
                        'ivanov@example.com'
                    ];
                    
                    foreach ($exampleData as $index => $data) {
                        $sheet->setCellValueByColumnAndRow($index + 1, 2, $data);
                    }
                    

                    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                    $tempPath = storage_path('app/temp_template.xlsx');
                    $writer->save($tempPath);
                    
                    return response()->download(
                        $tempPath,
                        'staff_import_template.xlsx'
                    )->deleteFileAfterSend(true);
                })
                ->modalSubmitActionLabel('Скачать')
                ->modalCancelActionLabel('Отмена'),
        ];
    }
}