<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LaborProtectionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'document_id',
        'description',
        'pdf_file',
        'file_size',
        'pages',
        'order',
        'is_published',
        'is_multilang',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'pages' => 'integer',
        'order' => 'integer',
        'is_multilang' => 'boolean',
        'published_at' => 'datetime',
    ];


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }


    public function getPdfUrlAttribute(): string
    {
        return Storage::disk('public_files')->url($this->pdf_file);
    }


    public function getDownloadPathAttribute(): string
    {
        return Storage::disk('public_files')->path($this->pdf_file);
    }


    public function fileExists(): bool
    {
        return Storage::disk('public_files')->exists($this->pdf_file);
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


    protected static function booted(): void
    {
        static::deleting(function (LaborProtectionDocument $document) {
            if ($document->fileExists()) {
                Storage::disk('public_files')->delete($document->pdf_file);
            }
        });
    }
}