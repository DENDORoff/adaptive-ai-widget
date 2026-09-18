<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Council extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'chairman',
        'meeting_frequency',
        'work_period',
        'contact_email',
        'order',
        'is_active',
        'is_multilang',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_multilang' => 'boolean',
    ];


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

    public function getChairmanAttribute($value)
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

    public function getMeetingFrequencyAttribute($value)
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

    public function getWorkPeriodAttribute($value)
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


    public function documents(): HasMany
    {
        return $this->hasMany(CouncilDocument::class)->orderBy('order');
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }


    public function getDocumentsCountAttribute(): int
    {
        return $this->documents()->count();
    }


    public function getForLanguage(string $language = 'ru'): array
    {

        if (!$this->is_multilang) {
            return [
                'title' => $this->getRawOriginal('title') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'chairman' => $this->getRawOriginal('chairman') ?? '',
                'meeting_frequency' => $this->getRawOriginal('meeting_frequency') ?? '',
                'work_period' => $this->getRawOriginal('work_period') ?? '',
            ];
        }

        try {

            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $chairmanData = json_decode($this->getRawOriginal('chairman'), true) ?? [];
            $meetingFrequencyData = json_decode($this->getRawOriginal('meeting_frequency'), true) ?? [];
            $workPeriodData = json_decode($this->getRawOriginal('work_period'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'chairman' => $chairmanData[$language] ?? $chairmanData['ru'] ?? '',
                'meeting_frequency' => $meetingFrequencyData[$language] ?? $meetingFrequencyData['ru'] ?? '',
                'work_period' => $workPeriodData[$language] ?? $workPeriodData['ru'] ?? '',
            ];
        } catch (\Exception $e) {

            return [
                'title' => '',
                'description' => '',
                'chairman' => '',
                'meeting_frequency' => '',
                'work_period' => '',
            ];
        }
    }


    public function getTranslatedTitle(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['title'];
    }


    public function getTranslatedDescription(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['description'];
    }


    public function getTranslatedChairman(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['chairman'];
    }


    public function getTranslatedMeetingFrequency(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['meeting_frequency'];
    }


    public function getTranslatedWorkPeriod(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['work_period'];
    }


    public function visibleDocuments()
    {
        return $this->documents()->where('is_visible', true)->orderBy('order');
    }


    public function hasDocuments(): bool
    {
        return $this->documents()->count() > 0;
    }


    public function getIconClassAttribute(): string
    {
        return $this->icon ?? 'fas fa-users';
    }
}