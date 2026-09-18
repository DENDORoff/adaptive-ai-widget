<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'specialty',
        'position',
        'story',
        'photo',
        'graduation_year',
        'company',
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


    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {

            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=3b82f6&color=fff&font-size=0.4';
        }

        return Storage::disk('public')->url($this->photo);
    }


    public function hasPhoto(): bool
    {
        return !empty($this->photo) && Storage::disk('public')->exists($this->photo);
    }


    public function getForLanguage(string $language = 'ru'): array
    {

        if (!$this->is_multilang) {
            return [
                'name' => $this->getRawOriginal('name') ?? '',
                'specialty' => $this->getRawOriginal('specialty') ?? '',
                'position' => $this->getRawOriginal('position') ?? '',
                'story' => $this->getRawOriginal('story') ?? '',
                'company' => $this->company,
            ];
        }

        try {

            $nameData = json_decode($this->getRawOriginal('name'), true) ?? [];
            $specialtyData = json_decode($this->getRawOriginal('specialty'), true) ?? [];
            $positionData = json_decode($this->getRawOriginal('position'), true) ?? [];
            $storyData = json_decode($this->getRawOriginal('story'), true) ?? [];
            $companyData = json_decode($this->getRawOriginal('company'), true) ?? [];
            
            return [
                'name' => $nameData[$language] ?? $nameData['ru'] ?? '',
                'specialty' => $specialtyData[$language] ?? $specialtyData['ru'] ?? '',
                'position' => $positionData[$language] ?? $positionData['ru'] ?? '',
                'story' => $storyData[$language] ?? $storyData['ru'] ?? '',
                'company' => $companyData[$language] ?? $companyData['ru'] ?? ($this->company ?? ''),
            ];
        } catch (\Exception $e) {

            return [
                'name' => '',
                'specialty' => '',
                'position' => '',
                'story' => '',
                'company' => $this->company ?? '',
            ];
        }
    }


    public function getTranslatedName(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['name'];
    }


    public function getTranslatedSpecialty(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['specialty'];
    }


    public function getTranslatedPosition(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['position'];
    }


    public function getTranslatedStory(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['story'];
    }


    public function getTranslatedCompany(): string
    {
        $locale = app()->getLocale();
        $company = $this->getForLanguage($locale)['company'];
        
        if ($this->is_multilang) {
            return $company;
        }
        
        return $this->company ?? '';
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


    public function getSpecialtyAttribute($value): string
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


    public function getPositionAttribute($value): string
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


    public function getStoryAttribute($value): string
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


    public function getCompanyAttribute($value): string
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


    public function getTableSpecialtyAttribute(): string
    {
        if ($this->is_multilang) {
            $rawSpecialty = $this->getRawOriginal('specialty');
            if (is_string($rawSpecialty)) {
                try {
                    $data = json_decode($rawSpecialty, true);
                    return $data['ru'] ?? ($this->specialty ?? '');
                } catch (\Exception $e) {
                    return $this->specialty ?? '';
                }
            }
        }
        return $this->specialty ?? '';
    }


    protected static function booted(): void
    {
        static::deleting(function (Graduate $graduate) {
            if ($graduate->hasPhoto()) {
                Storage::disk('public')->delete($graduate->photo);
            }
        });

        static::updating(function (Graduate $graduate) {
            if ($graduate->isDirty('photo') && $graduate->getOriginal('photo')) {
                Storage::disk('public')->delete($graduate->getOriginal('photo'));
            }
        });
    }
}