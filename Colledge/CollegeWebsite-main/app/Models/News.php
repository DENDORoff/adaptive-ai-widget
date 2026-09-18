<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'gallery',
        'is_published',
        'is_featured',
        'is_multilang',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_multilang' => 'boolean',
            'published_at' => 'datetime',
            'gallery' => 'array',

        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {

                $titleForSlug = $news->getTranslatedTitle('ru') ?? $news->title;
                $news->slug = Str::slug($titleForSlug);
            }
        });


        static::saved(function ($news) {
            Cache::forget("news.{$news->slug}.ru");
            Cache::forget("news.{$news->slug}.kk");
            Cache::forget("news.{$news->slug}.en");
        });

        static::deleted(function ($news) {
            Cache::forget("news.{$news->slug}.ru");
            Cache::forget("news.{$news->slug}.kk");
            Cache::forget("news.{$news->slug}.en");
        });
    }


    public function getTranslatedTitle(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        if (!$this->is_multilang) {
            return $this->title;
        }
        
        $titleData = $this->decodeField('title');
        
        if (!is_array($titleData)) {
            return $this->title;
        }
        

        if (isset($titleData[$locale]) && !empty($titleData[$locale])) {
            return $titleData[$locale];
        }
        

        if (isset($titleData['ru']) && !empty($titleData['ru'])) {
            return $titleData['ru'];
        }
        

        foreach ($titleData as $value) {
            if (!empty($value)) {
                return $value;
            }
        }
        
        return $this->title;
    }


    public function getTranslatedExcerpt(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        
        if (!$this->is_multilang) {
            return $this->excerpt;
        }
        
        $excerptData = $this->decodeField('excerpt');
        
        if (!is_array($excerptData)) {
            return $this->excerpt;
        }
        
        if (isset($excerptData[$locale]) && !empty($excerptData[$locale])) {
            return $excerptData[$locale];
        }
        
        if (isset($excerptData['ru'])) {
            return $excerptData['ru'];
        }
        
        foreach ($excerptData as $value) {
            if (!empty($value)) {
                return $value;
            }
        }
        
        return $this->excerpt;
    }


    public function getTranslatedContent(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        if (!$this->is_multilang) {
            return $this->content;
        }
        
        $contentData = $this->decodeField('content');
        
        if (!is_array($contentData)) {
            return $this->content;
        }
        
        if (isset($contentData[$locale]) && !empty($contentData[$locale])) {
            return $contentData[$locale];
        }
        
        if (isset($contentData['ru'])) {
            return $contentData['ru'];
        }
        
        foreach ($contentData as $value) {
            if (!empty($value)) {
                return $value;
            }
        }
        
        return $this->content;
    }


    public function getTranslations(string $field): array
    {
        if (!$this->is_multilang) {
            return [
                'ru' => $this->$field ?? '',
                'kk' => '',
                'en' => '',
            ];
        }
        
        $data = $this->decodeField($field);
        
        if (is_array($data)) {
            return $data;
        }
        
        return [
            'ru' => $this->$field ?? '',
            'kk' => '',
            'en' => '',
        ];
    }

 
    private function decodeField(string $field)
    {
        $value = $this->attributes[$field] ?? null;
        
        if (!$value) {
            return null;
        }
        

        if (is_array($value)) {
            return $value;
        }
        

        $decoded = json_decode($value, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        

        return $value;
    }


    public function getTitleAttribute($value)
    {

        if (!$this->is_multilang) {
            return $value;
        }
        

        return $this->getTranslatedTitle();
    }


    public function getExcerptAttribute($value)
    {
        if (!$this->is_multilang) {
            return $value;
        }
        
        return $this->getTranslatedExcerpt();
    }


    public function getContentAttribute($value)
    {
        if (!$this->is_multilang) {
            return $value;
        }
        
        return $this->getTranslatedContent();
    }


    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }


    public static function findBySlugCached(string $slug, ?string $locale = null): ?self
    {
        $locale = $locale ?? app()->getLocale();
        
        return Cache::remember(
            "news.{$slug}.{$locale}",
            now()->addHours(24),
            fn() => static::where('slug', $slug)->published()->first()
        );
    }
}