<?php

namespace App\Imports;

use App\Models\Staff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StaffImport implements ToCollection, WithHeadingRow
{
    private $importedCount = 0;
    private $updatedCount = 0;
    private $errors = [];
    

    private $jsonFields = [
        'full_name', 'position', 'bio', 'education', 'specialty',
        'diploma_specialty', 'diploma_qualification', 'teaching_subjects',
        'work_experience_total', 'work_experience_pedagogical',
        'category', 'awards', 'professional_development',
        'department', 'phone'
    ];
    

    private $isMultiLanguageFile = false;

    public function collection(Collection $rows)
    {
        Log::info('=== STAFF IMPORT START ===');
        
        if ($rows->isEmpty()) {
            Log::warning('Excel file is empty');
            return;
        }


        $firstRow = $rows->first();
        $headers = array_keys($firstRow->toArray());
        $this->detectFileType($headers);
        
        Log::info('File type detected: ' . ($this->isMultiLanguageFile ? 'Multi-language' : 'Single-language'));
        Log::info('Headers found:', $headers);

        foreach ($rows as $index => $row) {
            try {
                $excelRowNumber = $index + 2;
                
                Log::info("Processing row {$excelRowNumber}");
                

                $data = $this->isMultiLanguageFile 
                    ? $this->prepareMultiLanguageData($row, $excelRowNumber)
                    : $this->prepareSingleLanguageData($row, $excelRowNumber);
                

                if (empty($data['full_name']) || trim($data['full_name']) === '') {
                    $this->addError($excelRowNumber, 'ФИО обязательно для заполнения', $row->toArray());
                    continue;
                }
                
                if (empty($data['position']) || trim($data['position']) === '') {
                    $this->addError($excelRowNumber, 'Должность обязательна для заполнения', $row->toArray());
                    continue;
                }
                
                Log::info("Row {$excelRowNumber} valid, processing...");


                if (!$this->isMultiLanguageFile) {
                    $data = $this->convertToMultilangJson($data);
                }
                

                $data['is_multilang'] = true;
                $data['is_active'] = true;
                $data['order'] = $index;
                $data['is_leadership'] = false;
                

                $data = $this->ensureAllJsonFields($data);
                
                Log::info("Final data for row {$excelRowNumber}:", $data);


                DB::beginTransaction();
                
                try {

                    $staff = null;
                    if (!empty($data['email'])) {
                        $staff = Staff::where('email', $data['email'])->first();
                    }
                    

                    if (!$staff && !empty($data['full_name'])) {
                        $fullNameJson = json_decode($data['full_name'], true);
                        if (isset($fullNameJson['ru']) && !empty($fullNameJson['ru'])) {
                            $staff = Staff::whereJsonContains('full_name->ru', $fullNameJson['ru'])->first();
                        }
                    }

                    if ($staff) {
                        Log::info("Updating staff ID: {$staff->id}");
                        $staff->update($data);
                        $this->updatedCount++;
                    } else {
                        Log::info("Creating new staff");
                        Staff::create($data);
                        $this->importedCount++;
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
            'errors' => count($this->errors),
            'file_type' => $this->isMultiLanguageFile ? 'multi_language' : 'single_language'
        ]);
    }


    private function detectFileType(array $headers)
    {

        $multiLanguagePatterns = ['_ru', '_kk', '_en', '(рус)', '(каз)', '(англ)'];
        
        foreach ($headers as $header) {
            $headerLower = strtolower($header);
            foreach ($multiLanguagePatterns as $pattern) {
                if (strpos($headerLower, strtolower($pattern)) !== false) {
                    $this->isMultiLanguageFile = true;
                    Log::info("Detected multi-language header: {$header}");
                    return;
                }
            }
        }
        

        $oldHeaders = ['fio_polnostyu', 'zanimaemaa_dolznost', 'obrazovanie_god_okoncania'];
        foreach ($oldHeaders as $oldHeader) {
            if (in_array($oldHeader, $headers) || 
                in_array(strtolower($oldHeader), array_map('strtolower', $headers))) {
                $this->isMultiLanguageFile = false;
                Log::info("Detected single-language file with old headers");
                return;
            }
        }
        
        $this->isMultiLanguageFile = false;
        Log::info("Detected as single-language file by default");
    }


    private function prepareMultiLanguageData($row, $rowNumber): array
    {
        Log::info("Preparing multi-language data for row {$rowNumber}");
        
        $data = [];
        

        $fieldGroups = [
            'full_name' => ['full_name_ru', 'full_name_kk', 'full_name_en', 'fio_polnostyu_ru', 'fio_polnostyu_kk', 'fio_polnostyu_en'],
            'position' => ['position_ru', 'position_kk', 'position_en', 'zanimaemaa_dolznost_ru', 'zanimaemaa_dolznost_kk', 'zanimaemaa_dolznost_en'],
            'education' => ['education_ru', 'education_kk', 'education_en', 'obrazovanie_god_okoncania_ru', 'obrazovanie_god_okoncania_kk', 'obrazovanie_god_okoncania_en'],
            'diploma_specialty' => ['diploma_specialty_ru', 'diploma_specialty_kk', 'diploma_specialty_en', 'specialnost_po_diplomu_ru', 'specialnost_po_diplomu_kk', 'specialnost_po_diplomu_en'],
            'teaching_subjects' => ['teaching_subjects_ru', 'teaching_subjects_kk', 'teaching_subjects_en', 'kakoi_predmet_disciplinu_vedet_ru', 'kakoi_predmet_disciplinu_vedet_kk', 'kakoi_predmet_disciplinu_vedet_en'],
            'work_experience_total' => ['work_experience_total_ru', 'work_experience_total_kk', 'work_experience_total_en', 'staz_raboty_obsii_ru', 'staz_raboty_obsii_kk', 'staz_raboty_obsii_en'],
            'work_experience_pedagogical' => ['work_experience_pedagogical_ru', 'work_experience_pedagogical_kk', 'work_experience_pedagogical_en', 'staz_raboty_pedagogiceskii_ru', 'staz_raboty_pedagogiceskii_kk', 'staz_raboty_pedagogiceskii_en'],
            'category' => ['category_ru', 'category_kk', 'category_en', 'kategoria_ru', 'kategoria_kk', 'kategoria_en'],
            'awards' => ['awards_ru', 'awards_kk', 'awards_en', 'nagrady_ru', 'nagrady_kk', 'nagrady_en'],
            'professional_development' => ['professional_development_ru', 'professional_development_kk', 'professional_development_en', 'kursy_povysenia_kvalifikacii_ru', 'kursy_povysenia_kvalifikacii_kk', 'kursy_povysenia_kvalifikacii_en'],
            'email' => ['email', 'e-mail'],
        ];
        
        foreach ($fieldGroups as $field => $possibleHeaders) {
            $values = ['ru' => '', 'kk' => '', 'en' => ''];
            
            foreach ($possibleHeaders as $header) {
                if (isset($row[$header])) {
                    $value = $this->cleanValue($row[$header]);
                    

                    if (str_ends_with(strtolower($header), '_ru') || str_contains(strtolower($header), '(рус)')) {
                        $values['ru'] = $value;
                    } elseif (str_ends_with(strtolower($header), '_kk') || str_contains(strtolower($header), '(каз)')) {
                        $values['kk'] = $value;
                    } elseif (str_ends_with(strtolower($header), '_en') || str_contains(strtolower($header), '(англ)')) {
                        $values['en'] = $value;
                    } elseif ($field === 'email') {

                        $data[$field] = $value;
                    }
                }
            }
            

            if ($field !== 'email' && !empty(array_filter($values))) {
                $data[$field] = json_encode($values, JSON_UNESCAPED_UNICODE);
            }
        }
        

        $simpleFields = [
            'department' => ['department', 'отделение', 'otdelenie'],
            'phone' => ['phone', 'телефон', 'telefon'],
            'bio' => ['bio', 'биография', 'biografia'],
            'specialty' => ['specialty', 'специальность'],
            'diploma_qualification' => ['diploma_qualification', 'квалификация_по_диплому'],
        ];
        
        foreach ($simpleFields as $field => $possibleHeaders) {
            foreach ($possibleHeaders as $header) {
                if (isset($row[$header])) {
                    $value = $this->cleanValue($row[$header]);
                    if (!empty($value)) {
                        $data[$field] = json_encode(['ru' => $value, 'kk' => '', 'en' => ''], JSON_UNESCAPED_UNICODE);
                    }
                    break;
                }
            }
        }
        
        Log::info("Multi-language data prepared for row {$rowNumber}:", $data);
        
        return $data;
    }

    private function prepareSingleLanguageData($row, $rowNumber): array
    {
        Log::info("Preparing single-language data for row {$rowNumber}");
        

        $mapping = [
            'fio_polnostyu' => 'full_name',
            'zanimaemaa_dolznost' => 'position',
            'obrazovanie_god_okoncania' => 'education',
            'specialnost_po_diplomu' => 'diploma_specialty',
            'kakoi_predmet_disciplinu_vedet' => 'teaching_subjects',
            'staz_raboty_obsii' => 'work_experience_total',
            'staz_raboty_pedagogiceskii' => 'work_experience_pedagogical',
            'kategoria' => 'category',
            'nagrady' => 'awards',
            'kursy_povysenia_kvalifikacii' => 'professional_development',
            'email' => 'email',
        ];
        
        $data = [];
        foreach ($mapping as $excelKey => $dbField) {
            $value = $this->findValue($row, $excelKey);
            if ($value !== null) {
                $data[$dbField] = $value;
            }
        }
        
        Log::info("Single-language data prepared for row {$rowNumber}:", $data);
        
        return $data;
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
        
        return null;
    }
    
    private function cleanValue($value)
    {
        if (is_null($value)) {
            return '';
        }
        
        if (is_string($value)) {
            $value = trim($value);
            if ($value === '' || in_array(strtolower($value), ['null', 'нет', 'н/д', 'не указано'])) {
                return '';
            }
        }
        
        return $value;
    }


    private function convertToMultilangJson(array $data): array
    {
        foreach ($this->jsonFields as $field) {
            if (isset($data[$field]) && !empty(trim($data[$field]))) {
                $value = trim($data[$field]);
                

                if ($this->isJson($value)) {
                    continue;
                }
                

                $data[$field] = json_encode([
                    'ru' => $value,
                    'kk' => '',
                    'en' => ''
                ], JSON_UNESCAPED_UNICODE);
            } elseif (isset($data[$field])) {

                $data[$field] = json_encode([
                    'ru' => '',
                    'kk' => '',
                    'en' => ''
                ], JSON_UNESCAPED_UNICODE);
            }
        }

        return $data;
    }
    
    private function ensureAllJsonFields(array $data): array
    {
        foreach ($this->jsonFields as $field) {
            if (!isset($data[$field]) || !$this->isJson($data[$field])) {
                $value = $data[$field] ?? '';
                $data[$field] = json_encode([
                    'ru' => is_string($value) ? $value : '',
                    'kk' => '',
                    'en' => ''
                ], JSON_UNESCAPED_UNICODE);
            }
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
            'has_errors' => !empty($this->errors),
            'file_type' => $this->isMultiLanguageFile ? 'multi_language' : 'single_language'
        ];
    }
}