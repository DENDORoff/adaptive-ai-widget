<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'year',
        'status',
        'order',
        'is_active',
        'is_multilang',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'is_multilang' => 'boolean',
    ];


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }


    public static function getAvailableIcons(): array
    {
        return [
            'trophy' => 'Кубок',
            'medal' => 'Медаль',
            'certificate' => 'Сертификат',
            'lab' => 'Лаборатория',
            'briefcase' => 'Портфель',
            'handshake' => 'Рукопожатие',
        ];
    }


    public static function getStatuses(): array
    {
        return [
            'Актуально' => 'Актуально',
            'Архив' => 'Архив',
            'В процессе' => 'В процессе',
        ];
    }


    public function getForLanguage(string $language = 'ru'): array
    {

        if (!$this->is_multilang) {
            return [
                'title' => $this->getRawOriginal('title') ?? '',
                'description' => $this->getRawOriginal('description') ?? '',
                'status' => $this->status,
            ];
        }

        try {

            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $descriptionData = json_decode($this->getRawOriginal('description'), true) ?? [];
            $statusData = json_decode($this->getRawOriginal('status'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'description' => $descriptionData[$language] ?? $descriptionData['ru'] ?? '',
                'status' => $statusData[$language] ?? $statusData['ru'] ?? ($this->status ?? ''),
            ];
        } catch (\Exception $e) {

            return [
                'title' => '',
                'description' => '',
                'status' => $this->status ?? '',
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


    public function getTranslatedStatus(): string
    {
        $locale = app()->getLocale();
        $status = $this->getForLanguage($locale)['status'];
        
        if ($this->is_multilang) {

            return $status;
        }
        

        return $this->status;
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


    public function getStatusAttribute($value): string
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


    public function getTableStatusAttribute(): string
    {
        if ($this->is_multilang) {
            $rawStatus = $this->getRawOriginal('status');
            if (is_string($rawStatus)) {
                try {
                    $data = json_decode($rawStatus, true);
                    return $data['ru'] ?? ($this->status ?? '');
                } catch (\Exception $e) {
                    return $this->status ?? '';
                }
            }
        }
        return $this->status ?? '';
    }
}