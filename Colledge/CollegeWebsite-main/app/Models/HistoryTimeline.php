<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'date',
        'description',
        'order',
        'is_active',
        'position',
        'is_multilang',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
        'is_multilang' => 'boolean',
    ];

    protected $attributes = [
        'position' => 'left',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function getForLanguage(string $language = 'ru'): array
    {

        if (!$this->is_multilang) {
            return [
                'title' => $this->getRawOriginal('title') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
            ];
        }

        try {

            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
            ];
        } catch (\Exception $e) {

            return [
                'title' => '',
                'description' => '',
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
}