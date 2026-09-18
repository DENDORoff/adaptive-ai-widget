<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curator extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_name',
        'curator_position',
        'curator_email',
        'curator_phone',
        'curator_photo',
        'group_name',
        'specialty',
        'course',
        'students_count',
        'room_number',
        'consultation_schedule',
        'additional_info',
        'order',
        'is_active',
        'is_multilang',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_multilang' => 'boolean',
            'students_count' => 'integer',
            'course' => 'integer',
        ];
    }


    public function getCuratorNameAttribute($value)
    {
        return $this->getTranslatedField('curator_name', $value);
    }

    public function getCuratorPositionAttribute($value)
    {
        return $this->getTranslatedField('curator_position', $value);
    }

    public function getGroupNameAttribute($value)
    {
        return $this->getTranslatedField('group_name', $value);
    }

    public function getSpecialtyAttribute($value)
    {
        return $this->getTranslatedField('specialty', $value);
    }

    public function getRoomNumberAttribute($value)
    {
        return $this->getTranslatedField('room_number', $value);
    }

    public function getConsultationScheduleAttribute($value)
    {
        return $this->getTranslatedField('consultation_schedule', $value);
    }

    public function getAdditionalInfoAttribute($value)
    {
        return $this->getTranslatedField('additional_info', $value);
    }


    private function getTranslatedField(string $field, $value)
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && $decoded) {
                    $locale = app()->getLocale();
                    return $decoded[$locale] ?? $decoded['ru'] ?? $value;
                }
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value;
    }


    public function getForLanguage(string $language = 'ru'): array
    {
        if (!$this->is_multilang) {
            return [
                'curator_name' => $this->getRawOriginal('curator_name') ?? '',
                'curator_position' => $this->getRawOriginal('curator_position') ?? '',
                'group_name' => $this->getRawOriginal('group_name') ?? '',
                'specialty' => $this->getRawOriginal('specialty') ?? '',
                'room_number' => $this->getRawOriginal('room_number') ?? '',
                'consultation_schedule' => $this->getRawOriginal('consultation_schedule') ?? '',
                'additional_info' => $this->getRawOriginal('additional_info') ?? '',
            ];
        }

        try {
            $curatorNameData = json_decode($this->getRawOriginal('curator_name'), true) ?? [];
            $curatorPositionData = json_decode($this->getRawOriginal('curator_position'), true) ?? [];
            $groupNameData = json_decode($this->getRawOriginal('group_name'), true) ?? [];
            $specialtyData = json_decode($this->getRawOriginal('specialty'), true) ?? [];
            $roomNumberData = json_decode($this->getRawOriginal('room_number'), true) ?? [];
            $consultationScheduleData = json_decode($this->getRawOriginal('consultation_schedule'), true) ?? [];
            $additionalInfoData = json_decode($this->getRawOriginal('additional_info'), true) ?? [];
            
            return [
                'curator_name' => $curatorNameData[$language] ?? $curatorNameData['ru'] ?? '',
                'curator_position' => $curatorPositionData[$language] ?? $curatorPositionData['ru'] ?? '',
                'group_name' => $groupNameData[$language] ?? $groupNameData['ru'] ?? '',
                'specialty' => $specialtyData[$language] ?? $specialtyData['ru'] ?? '',
                'room_number' => $roomNumberData[$language] ?? $roomNumberData['ru'] ?? '',
                'consultation_schedule' => $consultationScheduleData[$language] ?? $consultationScheduleData['ru'] ?? '',
                'additional_info' => $additionalInfoData[$language] ?? $additionalInfoData['ru'] ?? '',
            ];
        } catch (\Exception $e) {
            return [
                'curator_name' => '',
                'curator_position' => '',
                'group_name' => '',
                'specialty' => '',
                'room_number' => '',
                'consultation_schedule' => '',
                'additional_info' => '',
            ];
        }
    }


    public function getTableColumnData(string $field): string
    {
        if (!$this->is_multilang) {
            return $this->getRawOriginal($field) ?? '';
        }
        
        $rawValue = $this->getRawOriginal($field);
        
        if (empty($rawValue)) {
            return '';
        }
        
        try {
            $decoded = json_decode($rawValue, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded['ru'] ?? $decoded['kk'] ?? $decoded['en'] ?? '';
            }
        } catch (\Exception $e) {
            // ignore
        }
        
        return $rawValue;
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('course', 'asc')
                    ->orderByRaw("
                        CASE 
                            WHEN is_multilang = true THEN 
                                COALESCE(NULLIF((group_name::json->>'ru')::text, ''), group_name::text)
                            ELSE 
                                group_name::text
                        END ASC
                    ")
                    ->orderBy('order', 'asc');
    }


    public static function getSpecialties()
    {
        return self::whereNotNull('specialty')
            ->where('specialty', '!=', '')
            ->where('is_active', true)
            ->get()
            ->map(function ($curator) {

                return $curator->specialty;
            })
            ->filter(function ($specialty) {
                return !empty($specialty) && trim($specialty) !== '';
            })
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }


    public static function getCourses()
    {
        return self::whereNotNull('course')
            ->where('is_active', true)
            ->distinct()
            ->pluck('course')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $currentLocale = app()->getLocale();
            
            $q->orWhere(function($q2) use ($search, $currentLocale) {
                $q2->where(function($q3) use ($search) {
                    $q3->where('curator_name', 'ilike', '%' . $search . '%')
                       ->where('is_multilang', false);
                })->orWhere(function($q3) use ($search, $currentLocale) {
                    $q3->where('is_multilang', true)
                       ->whereRaw("curator_name::json->>? ILIKE ?", [$currentLocale, '%' . $search . '%']);
                });
            })
            ->orWhere(function($q2) use ($search, $currentLocale) {
                $q2->where(function($q3) use ($search) {
                    $q3->where('group_name', 'ilike', '%' . $search . '%')
                       ->where('is_multilang', false);
                })->orWhere(function($q3) use ($search, $currentLocale) {
                    $q3->where('is_multilang', true)
                       ->whereRaw("group_name::json->>? ILIKE ?", [$currentLocale, '%' . $search . '%']);
                });
            })
            ->orWhere(function($q2) use ($search, $currentLocale) {
                $q2->where(function($q3) use ($search) {
                    $q3->where('specialty', 'ilike', '%' . $search . '%')
                       ->where('is_multilang', false);
                })->orWhere(function($q3) use ($search, $currentLocale) {
                    $q3->where('is_multilang', true)
                       ->whereRaw("specialty::json->>? ILIKE ?", [$currentLocale, '%' . $search . '%']);
                });
            });
        });
    }
}