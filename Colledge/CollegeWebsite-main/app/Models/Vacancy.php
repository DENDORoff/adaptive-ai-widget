<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'salary',
        'location',
        'employment_type',
        'pdf_file',
        'is_published',
        'published_at',
        'expires_at',
        'order',
        'is_multilang',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_multilang' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vacancy) {
            if (empty($vacancy->slug)) {
                $vacancy->slug = Str::slug($vacancy->title);
            }
            if (empty($vacancy->published_at) && $vacancy->is_published) {
                $vacancy->published_at = now();
            }
        });
    }


    public function getTitleAttribute($value)
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

    public function getDescriptionAttribute($value)
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

    public function getSalaryAttribute($value)
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

    public function getLocationAttribute($value)
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

    public function getEmploymentTypeAttribute($value)
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
                'title' => $this->getRawOriginal('title') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'salary' => $this->getRawOriginal('salary') ?? '',
                'location' => $this->getRawOriginal('location') ?? '',
                'employment_type' => $this->getRawOriginal('employment_type') ?? '',
            ];
        }

        try {
            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $salaryData = json_decode($this->getRawOriginal('salary'), true) ?? [];
            $locationData = json_decode($this->getRawOriginal('location'), true) ?? [];
            $employmentTypeData = json_decode($this->getRawOriginal('employment_type'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'salary' => $salaryData[$language] ?? $salaryData['ru'] ?? '',
                'location' => $locationData[$language] ?? $locationData['ru'] ?? '',
                'employment_type' => $employmentTypeData[$language] ?? $employmentTypeData['ru'] ?? '',
            ];
        } catch (\Exception $e) {
            return [
                'title' => '',
                'description' => '',
                'salary' => '',
                'location' => '',
                'employment_type' => '',
            ];
        }
    }

  
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', now());
                    });
    }

 
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', now());
        });
    }

 
    public function getPdfUrlAttribute()
    {
        if (!$this->pdf_file) {
            return null;
        }
        
       
        if (file_exists(public_path('uploads/' . $this->pdf_file))) {
            return asset('uploads/' . $this->pdf_file);
        }
        
        return asset('storage/' . $this->pdf_file);
    }

 
    public function getIsExpiredAttribute()
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at < now();
    }

  
    public function getStatusAttribute()
    {
        if (!$this->is_published) {
            return 'draft';
        }
        
        if ($this->is_expired) {
            return 'expired';
        }
        
        return 'active';
    }
}