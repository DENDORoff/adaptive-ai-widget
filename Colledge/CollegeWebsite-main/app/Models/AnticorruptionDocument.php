<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnticorruptionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'category',
        'pdf_file',
        'document_date',
        'is_published',
        'order',
        'is_multilang',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_multilang' => 'boolean',
        'document_date' => 'date',
    ];

    protected $appends = [
        'pdf_url',
        'category_icon',
        'category_color',
        'type_name',
        'category_label',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->slug)) {
                if ($document->is_multilang && !empty($document->getRawOriginal('title'))) {
                    try {
                        $data = json_decode($document->getRawOriginal('title'), true);
                        $russianTitle = $data['ru'] ?? '';
                        $document->slug = Str::slug($russianTitle ?: $document->title);
                    } catch (\Exception $e) {
                        $document->slug = Str::slug($document->title);
                    }
                } else {
                    $document->slug = Str::slug($document->title);
                }
            }
        });
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


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }


    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }


    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }


    public function getPdfUrlAttribute()
    {
        if (!$this->pdf_file) {
            return null;
        }
        
        return Storage::url($this->pdf_file);
    }


    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'law' => 'fas fa-gavel',
            'report' => 'fas fa-file-alt',
            'info' => 'fas fa-info-circle',
            'order' => 'fas fa-file-signature',
            default => 'fas fa-file-pdf',
        };
    }


    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'law' => 'text-yellow-400',
            'report' => 'text-blue-400',
            'info' => 'text-green-400',
            'order' => 'text-purple-400',
            default => 'text-gray-400',
        };
    }


    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'document' => 'Документ',
            'information' => 'Перечень сведений',
            default => 'Файл',
        };
    }


    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'law' => 'Нормативный акт',
            'report' => 'Отчет',
            'info' => 'Информация',
            'order' => 'Распоряжение',
            default => 'Документ',
        };
    }
}