<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class YouthEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'image',
        'gallery',
        'event_date',
        'event_time',
        'location',
        'type',
        'participants_count',
        'organizer',
        'tags',
        'registration_link',
        'is_featured',
        'is_published',
        'order',
        'is_multilang',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'gallery' => 'array',
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'is_multilang' => 'boolean',
    ];

    protected $appends = [
        'image_url',
        'gallery_urls',
        'formatted_date',
        'days_until',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return Storage::url($this->image);
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
                'title' => $this->getRawOriginal('title') ?? '',
                'short_description' => $this->getRawOriginal('short_description') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'location' => $this->location ?? '',
                'organizer' => $this->organizer ?? '',
            ];
        }

        try {
            
            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $shortDescriptionData = json_decode($this->getRawOriginal('short_description'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $locationData = json_decode($this->getRawOriginal('location'), true) ?? [];
            $organizerData = json_decode($this->getRawOriginal('organizer'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'short_description' => $shortDescriptionData[$language] ?? $shortDescriptionData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'location' => $locationData[$language] ?? $locationData['ru'] ?? ($this->location ?? ''),
                'organizer' => $organizerData[$language] ?? $organizerData['ru'] ?? ($this->organizer ?? ''),
            ];
        } catch (\Exception $e) {
            
            return [
                'title' => '',
                'short_description' => '',
                'description' => '',
                'location' => $this->location ?? '',
                'organizer' => $this->organizer ?? '',
            ];
        }
    }

   
    public function getTranslatedTitle(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['title'];
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

    
    public function getTranslatedLocation(): string
    {
        $locale = app()->getLocale();
        $location = $this->getForLanguage($locale)['location'];
        
        if ($this->is_multilang) {
            return $location;
        }
        
        return $this->location ?? '';
    }

    
    public function getTranslatedOrganizer(): string
    {
        $locale = app()->getLocale();
        $organizer = $this->getForLanguage($locale)['organizer'];
        
        if ($this->is_multilang) {
            return $organizer;
        }
        
        return $this->organizer ?? '';
    }

    
    public function getTitleAttribute($value): string
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

    
    public function getOrganizerAttribute($value): string
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

   
    public function getTableTitleAttribute(): string
    {
        if ($this->is_multilang) {
            $rawTitle = $this->getRawOriginal('title');
            if (is_string($rawTitle)) {
                try {
                    $data = json_decode($rawTitle, true);
                    return $data['ru'] ?? ($this->title ?? '');
                } catch (\Exception $e) {
                    return $this->title ?? '';
                }
            }
        }
        return $this->title ?? '';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('type', 'upcoming')
            ->where('event_date', '>=', now())
            ->orderBy('event_date');
    }

    public function scopeArchive($query)
    {
        return $query->where('type', 'archive')
            ->orWhere('event_date', '<', now())
            ->orderBy('event_date', 'desc');
    }

    public function scopeWeekEvents($query)
    {
        return $query->where('type', 'week_event');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('event_date');
    }

    public function isPast(): bool
    {
        return $this->event_date < now();
    }

    public function isSoon(): bool
    {
        $weekLater = now()->addWeek();
        return $this->event_date <= $weekLater && $this->event_date >= now();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->event_date->translatedFormat('d F Y');
    }

    public function getDaysUntilAttribute(): int
    {
        return max(0, now()->diffInDays($this->event_date, false));
    }
}