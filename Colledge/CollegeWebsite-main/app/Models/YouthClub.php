<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class YouthClub extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'icon',
        'color',
        'image',
        'category',
        'schedule',
        'location',
        'room',
        'instructor_name',
        'instructor_phone',
        'instructor_email',
        'instructor_photo',
        'max_participants',
        'current_participants',
        'age_min',
        'age_max',
        'price',
        'achievements',
        'gallery',
        'registration_link',
        'is_recruiting',
        'is_published',
        'is_featured',
        'order',
        'is_multilang',
    ];

    protected $casts = [
        'achievements' => 'array',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'is_recruiting' => 'boolean',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'is_multilang' => 'boolean',
    ];

    protected $appends = [
        'image_url',
        'instructor_photo_url',
        'gallery_urls',
        'occupancy_percentage',
        'available_spots',
        'category_label',
        'formatted_price',
        'age_range',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return Storage::url($this->image);
    }

    public function getInstructorPhotoUrlAttribute(): ?string
    {
        if (!$this->instructor_photo) {
            return null;
        }
        return Storage::disk('public_files')->url($this->instructor_photo);
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery) {
            return [];
        }
        return array_map(
            fn($path) => Storage::url($path),
            $this->gallery
        );
    }


    public function getForLanguage(string $language = 'ru'): array
    {
        
        if (!$this->is_multilang) {
            return [
                'name' => $this->getRawOriginal('name') ?? '',
                'short_description' => $this->getRawOriginal('short_description') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'schedule' => $this->schedule ?? '',
                'location' => $this->location ?? '',
                'room' => $this->room ?? '',
                'instructor_name' => $this->instructor_name ?? '',
            ];
        }

        try {
            
            $nameData = json_decode($this->getRawOriginal('name'), true) ?? [];
            $shortDescriptionData = json_decode($this->getRawOriginal('short_description'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $scheduleData = json_decode($this->getRawOriginal('schedule'), true) ?? [];
            $locationData = json_decode($this->getRawOriginal('location'), true) ?? [];
            $roomData = json_decode($this->getRawOriginal('room'), true) ?? [];
            $instructorNameData = json_decode($this->getRawOriginal('instructor_name'), true) ?? [];
            
            return [
                'name' => $nameData[$language] ?? $nameData['ru'] ?? '',
                'short_description' => $shortDescriptionData[$language] ?? $shortDescriptionData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'schedule' => $scheduleData[$language] ?? $scheduleData['ru'] ?? ($this->schedule ?? ''),
                'location' => $locationData[$language] ?? $locationData['ru'] ?? ($this->location ?? ''),
                'room' => $roomData[$language] ?? $roomData['ru'] ?? ($this->room ?? ''),
                'instructor_name' => $instructorNameData[$language] ?? $instructorNameData['ru'] ?? ($this->instructor_name ?? ''),
            ];
        } catch (\Exception $e) {
            
            return [
                'name' => '',
                'short_description' => '',
                'description' => '',
                'schedule' => $this->schedule ?? '',
                'location' => $this->location ?? '',
                'room' => $this->room ?? '',
                'instructor_name' => $this->instructor_name ?? '',
            ];
        }
    }


    public function getTranslatedName(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['name'];
    }


    public function getTranslatedShortDescription(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['short_description'];
    }

 
    public function getTranslatedDescription(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['description'];
    }

 
    public function getTranslatedSchedule(): string
    {
        $locale = app()->getLocale();
        $schedule = $this->getForLanguage($locale)['schedule'];
        
        if ($this->is_multilang) {
            return $schedule;
        }
        
        return $this->schedule ?? '';
    }

  
    public function getTranslatedLocation(): string
    {
        $locale = app()->getLocale();
        $location = $this->getForLanguage($locale)['location'];
        
        if ($this->is_multilang) {
            return $location;
        }
        
        return $this->location ?? '';
    }

   
    public function getTranslatedRoom(): string
    {
        $locale = app()->getLocale();
        $room = $this->getForLanguage($locale)['room'];
        
        if ($this->is_multilang) {
            return $room;
        }
        
        return $this->room ?? '';
    }

    
    public function getTranslatedInstructorName(): string
    {
        $locale = app()->getLocale();
        $instructorName = $this->getForLanguage($locale)['instructor_name'];
        
        if ($this->is_multilang) {
            return $instructorName;
        }
        
        return $this->instructor_name ?? '';
    }

    
    public function getNameAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

    
    public function getShortDescriptionAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

    
    public function getDescriptionAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

   
    public function getScheduleAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

    
    public function getLocationAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

    
    public function getRoomAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

   
    public function getInstructorNameAttribute($value): string
    {
        if ($this->is_multilang && is_string($value)) {
            try {
                $data = json_decode($value, true);
                $locale = app()->getLocale();
                return $data[$locale] ?? $data['ru'] ?? $value;
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value ?? '';
    }

    
    public function getTableNameAttribute(): string
    {
        if ($this->is_multilang) {
            $rawName = $this->getRawOriginal('name');
            if (is_string($rawName)) {
                try {
                    $data = json_decode($rawName, true);
                    return $data['ru'] ?? ($this->name ?? '');
                } catch (\Exception $e) {
                    return $this->name ?? '';
                }
            }
        }
        return $this->name ?? '';
    }

    
    public function getTableInstructorNameAttribute(): string
    {
        if ($this->is_multilang) {
            $rawInstructorName = $this->getRawOriginal('instructor_name');
            if (is_string($rawInstructorName)) {
                try {
                    $data = json_decode($rawInstructorName, true);
                    return $data['ru'] ?? ($this->instructor_name ?? '');
                } catch (\Exception $e) {
                    return $this->instructor_name ?? '';
                }
            }
        }
        return $this->instructor_name ?? '';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeRecruiting($query)
    {
        return $query->where('is_recruiting', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function hasAvailableSpots(): bool
    {
        if (!$this->max_participants) {
            return true;
        }
        return $this->current_participants < $this->max_participants;
    }

    public function getOccupancyPercentageAttribute(): float
    {
        if (!$this->max_participants) {
            return 0;
        }
        return ($this->current_participants / $this->max_participants) * 100;
    }

    public function getAvailableSpotsAttribute(): ?int
    {
        if (!$this->max_participants) {
            return null;
        }
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'sport' => 'Спорт',
            'art' => 'Искусство',
            'science' => 'Наука',
            'technology' => 'Технологии',
            'music' => 'Музыка',
            'dance' => 'Танцы',
            'theater' => 'Театр',
            'volunteer' => 'Волонтерство',
            default => 'Другое',
        };
    }

    public function isFree(): bool
    {
        return $this->price == 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->isFree()) {
            return 'Бесплатно';
        }
        return number_format($this->price, 0, ',', ' ') . ' ₸';
    }

    public function getAgeRangeAttribute(): ?string
    {
        if (!$this->age_min && !$this->age_max) {
            return null;
        }
        if ($this->age_min && $this->age_max) {
            return "{$this->age_min}-{$this->age_max} лет";
        }
        if ($this->age_min) {
            return "от {$this->age_min} лет";
        }
        return "до {$this->age_max} лет";
    }
}