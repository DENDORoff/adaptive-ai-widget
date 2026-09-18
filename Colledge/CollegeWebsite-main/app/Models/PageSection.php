<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'section_key',
        'title',
        'content',
        'description',
        'is_active',
        'is_multilang',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
        'is_multilang' => 'boolean',
    ];


    public function getContentAttribute($value)
    {

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }
            

            if (!empty($decoded) && is_array($decoded)) {
                $firstKey = key($decoded);
                

                if (!is_numeric($firstKey) && is_array($decoded[$firstKey])) {
                    $result = [];
                    foreach ($decoded as $key => $item) {
                        if (is_array($item) && (isset($item['ru']) || isset($item['kk']) || isset($item['en']))) {
                            $result[] = [
                                'key' => $key,
                                'ru' => $item['ru'] ?? '',
                                'kk' => $item['kk'] ?? '',
                                'en' => $item['en'] ?? '',
                            ];
                        } else {
                            $result[] = [
                                'key' => $key,
                                'value' => is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE) : $item,
                            ];
                        }
                    }
                    return $result;
                }
            }
            
            return $decoded;
        }
        
        return $value ?? [];
    }


    public function setContentAttribute($value)
    {

        if (is_null($value) || (is_array($value) && empty($value))) {
            $this->attributes['content'] = json_encode([]);
            return;
        }
        

        if (is_array($value)) {

            $this->attributes['content'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {

            $this->attributes['content'] = $value;
        }
    }


    public function getContentValue(string $key, $default = null)
    {
        $content = $this->content;
        
        if (empty($content) || !is_array($content)) {
            return $default;
        }
        

        foreach ($content as $item) {
            if (isset($item['key']) && $item['key'] === $key) {
                if ($this->is_multilang) {
                    $locale = app()->getLocale();
                    

                    if (isset($item[$locale]) && !empty($item[$locale])) {
                        return $item[$locale];
                    }
                    

                    if (isset($item['ru']) && !empty($item['ru'])) {
                        return $item['ru'];
                    }
                    

                    if (isset($item['kk']) && !empty($item['kk'])) {
                        return $item['kk'];
                    }
                    

                    if (isset($item['en']) && !empty($item['en'])) {
                        return $item['en'];
                    }
                    
                    return $default;
                } else {
                    return $item['value'] ?? $default;
                }
            }
        }
        
        return $default;
    }


    public function getContentTranslations(string $key): array
    {
        $content = $this->content;
        
        if (empty($content) || !is_array($content)) {
            return ['ru' => '', 'kk' => '', 'en' => ''];
        }
        

        foreach ($content as $item) {
            if (isset($item['key']) && $item['key'] === $key) {
                if ($this->is_multilang) {
                    return [
                        'ru' => $item['ru'] ?? '',
                        'kk' => $item['kk'] ?? '',
                        'en' => $item['en'] ?? '',
                    ];
                } else {
                    return [
                        'ru' => $item['value'] ?? '',
                        'kk' => '',
                        'en' => '',
                    ];
                }
            }
        }
        
        return ['ru' => '', 'kk' => '', 'en' => ''];
    }


    public function setMultilangContentValue(string $key, array $translations): void
    {
        $content = $this->content ?? [];
        $updated = false;
        

        foreach ($content as &$item) {
            if (isset($item['key']) && $item['key'] === $key) {
                $item['ru'] = $translations['ru'] ?? '';
                $item['kk'] = $translations['kk'] ?? '';
                $item['en'] = $translations['en'] ?? '';
                $updated = true;
                break;
            }
        }
        

        if (!$updated) {
            $content[] = [
                'key' => $key,
                'ru' => $translations['ru'] ?? '',
                'kk' => $translations['kk'] ?? '',
                'en' => $translations['en'] ?? '',
            ];
        }
        
        $this->content = $content;
        $this->is_multilang = true;
    }


    public function getImage(string $key): ?string
    {
        $imagePath = $this->getContentValue($key);
        
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::url($imagePath);
        }
        
        return null;
    }


    public function getImages(string $key): array
    {
        $images = $this->getContentValue($key, []);
        
        return collect($images)
            ->filter(fn($path) => Storage::disk('public')->exists($path))
            ->map(fn($path) => Storage::url($path))
            ->toArray();
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function scopeForPage($query, string $pageKey)
    {
        return $query->where('page_key', $pageKey);
    }


    public static function getSection(string $pageKey, string $sectionKey)
    {
        $locale = app()->getLocale();
        
        return Cache::remember(
            "page_section.{$pageKey}.{$sectionKey}.{$locale}",
            now()->addHours(24),
            fn() => static::where('page_key', $pageKey)
                ->where('section_key', $sectionKey)
                ->where('is_active', true)
                ->first()
        );
    }


    public static function getValue(string $pageKey, string $sectionKey, string $contentKey, $default = null)
    {
        $section = static::getSection($pageKey, $sectionKey);
        
        return $section ? $section->getContentValue($contentKey, $default) : $default;
    }


    public static function getAllValues(string $pageKey, string $sectionKey): array
    {
        $section = static::getSection($pageKey, $sectionKey);
        
        if (!$section) {
            return [];
        }
        
        $result = [];
        $content = $section->content;
        
        if (!is_array($content) || empty($content)) {
            return [];
        }
        
        foreach ($content as $item) {
            if (isset($item['key'])) {
                $result[$item['key']] = $section->getContentValue($item['key']);
            }
        }
        
        return $result;
    }


    public static function getMetadata(string $pageKey): array
    {
        $section = static::getSection($pageKey, 'metadata');
        
        if (!$section) {
            return [
                'title' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => [],
            ];
        }
        
        return [
            'title' => $section->getContentValue('title', ''),
            'meta_title' => $section->meta_title ?: $section->getContentValue('title', ''),
            'meta_description' => $section->meta_description ?: $section->getContentValue('description', ''),
            'meta_keywords' => $section->meta_keywords ?? [],
        ];
    }


    public static function clearCacheForSection(string $pageKey, string $sectionKey): void
    {
        $locales = ['ru', 'kk', 'en'];
        
        foreach ($locales as $locale) {
            Cache::forget("page_section.{$pageKey}.{$sectionKey}.{$locale}");
        }
        
        Cache::forget("page_sections.{$pageKey}");
    }


    public static function clearCacheForPage(string $pageKey): void
    {
        $locales = ['ru', 'kk', 'en'];
        
        foreach ($locales as $locale) {
            $sections = static::where('page_key', $pageKey)->pluck('section_key');
            
            foreach ($sections as $sectionKey) {
                Cache::forget("page_section.{$pageKey}.{$sectionKey}.{$locale}");
            }
        }
        
        Cache::forget("page_sections.{$pageKey}");
    }


    public static function clearAllPagesCache(): void
    {
        $pages = static::distinct('page_key')->pluck('page_key');
        
        foreach ($pages as $pageKey) {
            static::clearCacheForPage($pageKey);
        }
    }


    protected static function booted()
    {
        static::saving(function ($section) {
            \Log::info("PageSection saving: {$section->page_key}.{$section->section_key}");
            static::clearCacheForSection($section->page_key, $section->section_key);
        });

        static::saved(function ($section) {
            \Log::info("PageSection saved: {$section->page_key}.{$section->section_key}");
            static::clearCacheForSection($section->page_key, $section->section_key);
        });

        static::deleted(function ($section) {
            \Log::info("PageSection deleted: {$section->page_key}.{$section->section_key}");
            static::clearCacheForSection($section->page_key, $section->section_key);
        });
    }


    public function hasContent(string $key): bool
    {
        return !empty($this->getContentValue($key));
    }


    public function getAllContent(): array
    {
        return $this->content ?? [];
    }


    public function setContentValue(string $key, $value): void
    {
        $content = $this->content ?? [];
        $updated = false;
        

        foreach ($content as &$item) {
            if (isset($item['key']) && $item['key'] === $key) {
                if ($this->is_multilang) {
                    if (is_array($value) && isset($value['ru'])) {
                        $item['ru'] = $value['ru'] ?? '';
                        $item['kk'] = $value['kk'] ?? '';
                        $item['en'] = $value['en'] ?? '';
                    } else {

                        $item['ru'] = (string) $value;
                        $item['kk'] = (string) $value;
                        $item['en'] = (string) $value;
                    }
                } else {
                    $item['value'] = $value;
                }
                $updated = true;
                break;
            }
        }
        

        if (!$updated) {
            if ($this->is_multilang) {
                if (is_array($value) && isset($value['ru'])) {
                    $content[] = [
                        'key' => $key,
                        'ru' => $value['ru'] ?? '',
                        'kk' => $value['kk'] ?? '',
                        'en' => $value['en'] ?? '',
                    ];
                } else {
                    $content[] = [
                        'key' => $key,
                        'ru' => (string) $value,
                        'kk' => (string) $value,
                        'en' => (string) $value,
                    ];
                }
            } else {
                $content[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        }
        
        $this->content = $content;
    }


    public function removeContentValue(string $key): void
    {
        $content = $this->content ?? [];
        
        foreach ($content as $index => $item) {
            if (isset($item['key']) && $item['key'] === $key) {
                unset($content[$index]);
                break;
            }
        }
        
        $this->content = array_values($content);
    }


    public function getContentJson(): string
    {
        return json_encode($this->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    public function setContentFromJson(string $json): void
    {
        $this->content = json_decode($json, true);
    }


    public function getContentTitle()
    {
        return $this->getContentValue('title');
    }
    
    public function getContentDescription()
    {
        return $this->getContentValue('description');
    }


    public static function getFrontendValue(string $pageKey, string $sectionKey, string $contentKey, $default = null)
    {

        if (config('app.debug')) {
            $section = static::where('page_key', $pageKey)
                ->where('section_key', $sectionKey)
                ->where('is_active', true)
                ->first();
                
            return $section ? $section->getContentValue($contentKey, $default) : $default;
        }
        
        return static::getValue($pageKey, $sectionKey, $contentKey, $default);
    }


    public static function getFrontendValues(string $pageKey, string $sectionKey): array
    {

        if (config('app.debug')) {
            $section = static::where('page_key', $pageKey)
                ->where('section_key', $sectionKey)
                ->where('is_active', true)
                ->first();
                
            if (!$section) {
                return [];
            }
            
            $result = [];
            $content = $section->content;
            
            if (!is_array($content) || empty($content)) {
                return [];
            }
            
            foreach ($content as $item) {
                if (isset($item['key'])) {
                    $result[$item['key']] = $section->getContentValue($item['key']);
                }
            }
            
            return $result;
        }
        
        return static::getAllValues($pageKey, $sectionKey);
    }
    

    public static function fixContentFormat(): void
    {
        $sections = static::all();
        
        foreach ($sections as $section) {
            $oldContent = $section->getRawOriginal('content');
            
            if (is_string($oldContent)) {
                $decoded = json_decode($oldContent, true);
                
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $firstKey = key($decoded);
                    

                    if (!is_numeric($firstKey) && is_array($decoded[$firstKey])) {

                        $section->save();
                        \Log::info("Fixed format for: {$section->page_key}.{$section->section_key}");
                    }
                }
            }
        }
    }
}