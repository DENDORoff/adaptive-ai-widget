<?php

namespace App\Imports;

use App\Models\Curator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CuratorsImport implements ToCollection, WithHeadingRow
{
    private $importedCount = 0;
    private $updatedCount = 0;
    private $errors = [];
    
    public function collection(Collection $rows)
    {
        Log::info('=== CURATORS IMPORT START ===');
        
        if ($rows->isEmpty()) {
            Log::warning('Excel file is empty');
            return;
        }

        foreach ($rows as $index => $row) {
            try {
                $excelRowNumber = $index + 2;
                
                Log::info("Processing row {$excelRowNumber}");
                
                $data = $this->prepareData($row, $excelRowNumber);
                

                if (empty($data['curator_name']) || trim($data['curator_name']) === '') {
                    $this->addError($excelRowNumber, 'ФИО куратора обязательно для заполнения', $row->toArray());
                    continue;
                }
                
                if (empty($data['group_name']) || trim($data['group_name']) === '') {
                    $this->addError($excelRowNumber, 'Название группы обязательно для заполнения', $row->toArray());
                    continue;
                }
                
                if (empty($data['specialty']) || trim($data['specialty']) === '') {
                    $this->addError($excelRowNumber, 'Специальность обязательна для заполнения', $row->toArray());
                    continue;
                }
                

                if (!isset($data['course']) || empty($data['course'])) {
                    $data['course'] = $this->determineCourseFromGroupName($data['group_name']);
                }
                
                Log::info("Row {$excelRowNumber} valid, processing...");


                Log::info("Before convertToJson - room_number value: '" . ($data['room_number'] ?? 'NOT_SET') . "'");
                Log::info("Before convertToJson - specialty value: '" . ($data['specialty'] ?? 'NOT_SET') . "'");


                $data = $this->convertToJson($data);
                

                Log::info("After convertToJson - room_number is JSON: " . ($this->isJson($data['room_number'] ?? '') ? 'YES' : 'NO'));
                Log::info("After convertToJson - specialty is JSON: " . ($this->isJson($data['specialty'] ?? '') ? 'YES' : 'NO'));
                Log::info("After convertToJson - room_number value: " . ($data['room_number'] ?? 'NULL'));
                
                $data['is_multilang'] = true;
                $data['is_active'] = true;
                $data['order'] = $index;
                
                Log::info("Final data for row {$excelRowNumber}:", $data);


                DB::beginTransaction();
                
                try {

                    $groupName = $data['group_name'];
                    if ($this->isJson($groupName)) {
                        $groupData = json_decode($groupName, true);
                        $groupName = $groupData['ru'] ?? $data['group_name'];
                    }
                    
                    $curator = Curator::where('group_name', 'ilike', $groupName)->first();

                    if ($curator) {
                        Log::info("Updating curator ID: {$curator->id}");
                        $curator->update($data);
                        $this->updatedCount++;
                        

                        $curator->refresh();
                        $roomRaw = $curator->getRawOriginal('room_number');
                        Log::info("After update - room_number raw: '{$roomRaw}'");
                        Log::info("After update - room_number is JSON: " . ($this->isJson($roomRaw) ? 'YES' : 'NO'));
                    } else {
                        Log::info("Creating new curator");
                        $newCurator = Curator::create($data);
                        $this->importedCount++;
                        

                        $roomRaw = $newCurator->getRawOriginal('room_number');
                        Log::info("After create - room_number raw: '{$roomRaw}'");
                        Log::info("After create - room_number is JSON: " . ($this->isJson($roomRaw) ? 'YES' : 'NO'));
                    }
                    
                    DB::commit();
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }

            } catch (\Exception $e) {
                Log::error("Error processing row {$excelRowNumber}: " . $e->getMessage());
                
                $this->errors[] = [
                    'row' => $excelRowNumber,
                    'error' => $e->getMessage(),
                    'data' => isset($data) ? $data : null
                ];
            }
        }

        Log::info('=== IMPORT COMPLETED ===', [
            'imported' => $this->importedCount,
            'updated' => $this->updatedCount,
            'errors' => count($this->errors)
        ]);
    }


    private function prepareData($row, $rowNumber): array
    {
        $data = [];
        

        $fields = [
            'curator_name',
            'group_name',
            'specialty',
            'students_count',
            'room_number',
            'curator_email',
            'curator_phone',
            'course',
            'curator_position',
            'consultation_schedule',
            'additional_info'
        ];
        
        foreach ($fields as $dbField) {
            $value = $this->findValue($row, $dbField);
            if ($value !== null) {
                $data[$dbField] = $value;
                Log::info("Field {$dbField} from Excel: '{$value}'");
            } else {
                $data[$dbField] = ''; 
                Log::info("Field {$dbField} not found in Excel, setting to empty");
            }
        }
        
        return $data;
    }
    

    private function determineCourseFromGroupName($groupName): int
    {
        if ($this->isJson($groupName)) {
            $groupData = json_decode($groupName, true);
            $groupName = $groupData['ru'] ?? '';
        }
        
        if (preg_match('/[A-Za-zА-Яа-я]+-(\d{2})-\d+/', $groupName, $matches)) {
            $year = (int) $matches[1];
            $currentYear = (int) date('y');
            $course = ($currentYear - $year) + 1;
            
            if ($course < 1) $course = 1;
            if ($course > 4) $course = 4;
            
            Log::info("Determined course {$course} from group name: {$groupName}");
            return $course;
        }
        
        return 1;
    }
    
    private function findValue($row, $key)
    {

        if (isset($row[$key])) {
            return $this->cleanValue($row[$key]);
        }
        

        $keyLower = strtolower($key);
        foreach ($row as $header => $value) {
            if (strtolower($header) === $keyLower) {
                return $this->cleanValue($value);
            }
        }
        

        if ($key === 'specialty') {
            if (isset($row['specialt'])) {
                Log::info("Found 'specialt' instead of 'specialty', using it");
                return $this->cleanValue($row['specialt']);
            }
        }
        
        return null;
    }
    
    private function cleanValue($value)
    {
        if (is_null($value)) {
            return '';
        }
        
        if (is_string($value)) {
            $value = trim($value);
            if ($value === '' || in_array(strtolower($value), ['null', 'нет', 'н/д', 'не указано', '-'])) {
                return '';
            }
        }
        
        return $value;
    }


    private function convertToJson(array $data): array
    {
        $jsonFields = [
            'curator_name', 'curator_position', 'group_name', 'specialty',
            'room_number', 'consultation_schedule', 'additional_info'
        ];
        
        foreach ($jsonFields as $field) {

            if (!isset($data[$field])) {
                $data[$field] = '';
            }
            
            $value = $data[$field];
            

            if ($this->isJson($value)) {
                Log::info("Field {$field} is already JSON");
                continue;
            }
            

            $jsonValue = json_encode([
                'ru' => $value,
                'kk' => '',
                'en' => ''
            ], JSON_UNESCAPED_UNICODE);
            
            $data[$field] = $jsonValue;
            Log::info("Converted {$field}: '{$value}' -> {$jsonValue}");
        }

        return $data;
    }
    
    private function isJson($string): bool
    {
        if (!is_string($string) || trim($string) === '') {
            return false;
        }
        
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    private function addError($rowNumber, $message, $rawData)
    {
        $this->errors[] = [
            'row' => $rowNumber,
            'error' => $message,
            'raw_data' => $rawData
        ];
        
        Log::warning("Row {$rowNumber} error: {$message}");
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function getResults()
    {
        return [
            'imported' => $this->importedCount,
            'updated' => $this->updatedCount,
            'total' => $this->importedCount + $this->updatedCount,
            'errors' => $this->errors,
            'has_errors' => !empty($this->errors)
        ];
    }
}