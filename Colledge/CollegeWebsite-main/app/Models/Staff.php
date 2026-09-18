<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'position',
        'department',
        'specialty',
        'photo',
        'email',
        'phone',
        'bio',
        'order',
        'is_multilang',
        'is_leadership',
        'education',
        'diploma_specialty',
        'diploma_qualification',
        'teaching_subjects',
        'work_experience_total',
        'work_experience_pedagogical',
        'category',
        'awards',
        'professional_development',
    ];

    protected $casts = [
        'is_multilang' => 'boolean',
        'is_leadership' => 'boolean',
    ];


    public function getFullNameAttribute($value)
    {
        return $this->getTranslatedField('full_name', $value);
    }

    public function getPositionAttribute($value)
    {
        return $this->getTranslatedField('position', $value);
    }

    public function getBioAttribute($value)
    {
        return $this->getTranslatedField('bio', $value);
    }

    public function getEducationAttribute($value)
    {
        return $this->getTranslatedField('education', $value);
    }

    public function getSpecialtyAttribute($value)
    {
        return $this->getTranslatedField('specialty', $value);
    }

    public function getDiplomaSpecialtyAttribute($value)
    {
        return $this->getTranslatedField('diploma_specialty', $value);
    }

    public function getDiplomaQualificationAttribute($value)
    {
        return $this->getTranslatedField('diploma_qualification', $value);
    }

    public function getTeachingSubjectsAttribute($value)
    {
        return $this->getTranslatedField('teaching_subjects', $value);
    }

    public function getWorkExperienceTotalAttribute($value)
    {
        return $this->getTranslatedField('work_experience_total', $value);
    }

    public function getWorkExperiencePedagogicalAttribute($value)
    {
        return $this->getTranslatedField('work_experience_pedagogical', $value);
    }

    public function getCategoryAttribute($value)
    {
        return $this->getTranslatedField('category', $value);
    }

    public function getAwardsAttribute($value)
    {
        return $this->getTranslatedField('awards', $value);
    }

    public function getProfessionalDevelopmentAttribute($value)
    {
        return $this->getTranslatedField('professional_development', $value);
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
                'full_name' => $this->getRawOriginal('full_name') ?? '',
                'position' => $this->getRawOriginal('position') ?? '',
                'bio' => $this->getRawOriginal('bio') ?? '',
                'education' => $this->getRawOriginal('education') ?? '',
                'specialty' => $this->getRawOriginal('specialty') ?? '',
                'diploma_specialty' => $this->getRawOriginal('diploma_specialty') ?? '',
                'diploma_qualification' => $this->getRawOriginal('diploma_qualification') ?? '',
                'teaching_subjects' => $this->getRawOriginal('teaching_subjects') ?? '',
                'work_experience_total' => $this->getRawOriginal('work_experience_total') ?? '',
                'work_experience_pedagogical' => $this->getRawOriginal('work_experience_pedagogical') ?? '',
                'category' => $this->getRawOriginal('category') ?? '',
                'awards' => $this->getRawOriginal('awards') ?? '',
                'professional_development' => $this->getRawOriginal('professional_development') ?? '',
            ];
        }

        try {
            $fullNameData = json_decode($this->getRawOriginal('full_name'), true) ?? [];
            $positionData = json_decode($this->getRawOriginal('position'), true) ?? [];
            $bioData = json_decode($this->getRawOriginal('bio'), true) ?? [];
            $educationData = json_decode($this->getRawOriginal('education'), true) ?? [];
            $specialtyData = json_decode($this->getRawOriginal('specialty'), true) ?? [];
            $diplomaSpecialtyData = json_decode($this->getRawOriginal('diploma_specialty'), true) ?? [];
            $diplomaQualificationData = json_decode($this->getRawOriginal('diploma_qualification'), true) ?? [];
            $teachingSubjectsData = json_decode($this->getRawOriginal('teaching_subjects'), true) ?? [];
            $workExperienceTotalData = json_decode($this->getRawOriginal('work_experience_total'), true) ?? [];
            $workExperiencePedagogicalData = json_decode($this->getRawOriginal('work_experience_pedagogical'), true) ?? [];
            $categoryData = json_decode($this->getRawOriginal('category'), true) ?? [];
            $awardsData = json_decode($this->getRawOriginal('awards'), true) ?? [];
            $professionalDevelopmentData = json_decode($this->getRawOriginal('professional_development'), true) ?? [];
            
            return [
                'full_name' => $fullNameData[$language] ?? $fullNameData['ru'] ?? '',
                'position' => $positionData[$language] ?? $positionData['ru'] ?? '',
                'bio' => $bioData[$language] ?? $bioData['ru'] ?? '',
                'education' => $educationData[$language] ?? $educationData['ru'] ?? '',
                'specialty' => $specialtyData[$language] ?? $specialtyData['ru'] ?? '',
                'diploma_specialty' => $diplomaSpecialtyData[$language] ?? $diplomaSpecialtyData['ru'] ?? '',
                'diploma_qualification' => $diplomaQualificationData[$language] ?? $diplomaQualificationData['ru'] ?? '',
                'teaching_subjects' => $teachingSubjectsData[$language] ?? $teachingSubjectsData['ru'] ?? '',
                'work_experience_total' => $workExperienceTotalData[$language] ?? $workExperienceTotalData['ru'] ?? '',
                'work_experience_pedagogical' => $workExperiencePedagogicalData[$language] ?? $workExperiencePedagogicalData['ru'] ?? '',
                'category' => $categoryData[$language] ?? $categoryData['ru'] ?? '',
                'awards' => $awardsData[$language] ?? $awardsData['ru'] ?? '',
                'professional_development' => $professionalDevelopmentData[$language] ?? $professionalDevelopmentData['ru'] ?? '',
            ];
        } catch (\Exception $e) {
            return [
                'full_name' => '',
                'position' => '',
                'bio' => '',
                'education' => '',
                'specialty' => '',
                'diploma_specialty' => '',
                'diploma_qualification' => '',
                'teaching_subjects' => '',
                'work_experience_total' => '',
                'work_experience_pedagogical' => '',
                'category' => '',
                'awards' => '',
                'professional_development' => '',
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

  
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((full_name::json->>\'ru\')::text, \'\'), full_name::text)
                        ELSE 
                            full_name::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((position::json->>\'ru\')::text, \'\'), position::text)
                        ELSE 
                            position::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere('department', 'ilike', '%' . $search . '%')
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((specialty::json->>\'ru\')::text, \'\'), specialty::text)
                        ELSE 
                            specialty::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((teaching_subjects::json->>\'ru\')::text, \'\'), teaching_subjects::text)
                        ELSE 
                            teaching_subjects::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((education::json->>\'ru\')::text, \'\'), education::text)
                        ELSE 
                            education::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((diploma_specialty::json->>\'ru\')::text, \'\'), diploma_specialty::text)
                        ELSE 
                            diploma_specialty::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            })
            ->orWhere(function($q2) use ($search) {
                $q2->whereRaw('
                    CASE 
                        WHEN is_multilang = true THEN 
                            COALESCE(NULLIF((category::json->>\'ru\')::text, \'\'), category::text)
                        ELSE 
                            category::text
                    END ILIKE ?
                ', ['%' . $search . '%']);
            });
        });
    }

    public function scopeLeadership($query)
    {
        return $query->where('is_leadership', true);
    }

    public function scopeTeachers($query)
    {
        return $query->where('is_leadership', false);
    }

    public static function getDepartments()
    {
        return self::whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->filter()
            ->sort()
            ->values();
    }

    public static function getSpecialties()
    {
        return self::whereNotNull('specialty')
            ->distinct()
            ->pluck('specialty')
            ->filter()
            ->sort()
            ->values();
    }

    public function scopeByDepartment($query, $department)
    {
        if (!$department) {
            return $query;
        }

        return $query->where('department', $department);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('uploads/' . $this->photo))) {
            return asset('uploads/' . $this->photo);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . 
               '&size=256&background=1e40af&color=fff&font-size=0.4&bold=true';
    }

    public function getShortNameAttribute()
    {
        $fullName = $this->full_name;
        $parts = explode(' ', $fullName);
        if (count($parts) >= 3) {
            $firstName = mb_substr($parts[1], 0, 1) . '.';
            $middleName = mb_substr($parts[2], 0, 1) . '.';
            return $parts[0] . ' ' . $firstName . $middleName;
        }
        
        return $fullName;
    }

    public function getExperienceNumericAttribute()
    {
        $experience = $this->work_experience_pedagogical;
            
        if (preg_match('/\d+/', $experience, $matches)) {
            return (int) $matches[0];
        }
        
        return 0;
    }

    public function getHasCategoryAttribute()
    {
        $category = $this->category;
        return !empty($category) && strtolower($category) !== 'нет';
    }

    public function getAwardsListAttribute()
    {
        $awards = $this->awards;
        
        if (empty($awards)) {
            return [];
        }

        return array_map('trim', explode(',', $awards));
    }

    public function getSubjectsListAttribute()
    {
        $subjects = $this->teaching_subjects;
            
        if (empty($subjects)) {
            return [];
        }

        return array_map('trim', explode(',', $subjects));
    }

    public function getCategoryColorAttribute()
    {
        $category = strtolower($this->category ?? '');
        
        return match($category) {
            'высшая' => 'green',
            'первая' => 'blue',
            'вторая' => 'yellow',
            default => 'gray'
        };
    }
}