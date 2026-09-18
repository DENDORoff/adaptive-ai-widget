<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouthAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'icon',
        'published_at',
        'expires_at',
        'priority',
        'is_pinned',
        'is_published',
        'is_multilang',
        'order',
        'action_url',
        'action_text',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
        'is_multilang' => 'boolean',
    ];

    protected $appends = [
        'type_color',
        'priority_label',
        'type_label',
        'translated_title',
        'translated_content',
        'translated_action_text',
    ];

 
    public function getForLanguage(string $language = 'ru'): array
    {
        
        if (!$this->is_multilang) {
            return [
                'title' => $this->getRawOriginal('title') ?? '',
                'content' => $this->getRawOriginal('content') ?? '',
                'action_text' => $this->action_text ?? '',
            ];
        }

        try {
            
            $titleData = json_decode($this->getRawOriginal('title'), true) ?? [];
            $contentData = json_decode($this->getRawOriginal('content'), true) ?? [];
            $actionTextData = json_decode($this->getRawOriginal('action_text'), true) ?? [];
            
            return [
                'title' => $titleData[$language] ?? $titleData['ru'] ?? '',
                'content' => $contentData[$language] ?? $contentData['ru'] ?? '',
                'action_text' => $actionTextData[$language] ?? $actionTextData['ru'] ?? ($this->action_text ?? ''),
            ];
        } catch (\Exception $e) {
            
            return [
                'title' => '',
                'content' => '',
                'action_text' => $this->action_text ?? '',
            ];
        }
    }

 
    public function getTranslatedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['title'];
    }

 
    public function getTranslatedContentAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['content'];
    }

  
    public function getTranslatedActionTextAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->getForLanguage($locale)['action_text'];
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


    public function getContentAttribute($value): string
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


    public function getActionTextAttribute($value): string
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


    public function getTableContentAttribute(): string
    {
        if ($this->is_multilang) {
            $rawContent = $this->getRawOriginal('content');
            if (is_string($rawContent)) {
                try {
                    $data = json_decode($rawContent, true);
                    return $data['ru'] ?? ($this->content ?? '');
                } catch (\Exception $e) {
                    return $this->content ?? '';
                }
            }
        }
        return $this->content ?? '';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeByPriority($query)
    {
        return $query->orderByRaw(
            "CASE priority 
                WHEN 'urgent' THEN 1 
                WHEN 'high' THEN 2 
                WHEN 'normal' THEN 3 
                WHEN 'low' THEN 4 
                ELSE 5 
            END"
        );
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_pinned', 'desc')
            ->orderByRaw(
                "CASE priority 
                    WHEN 'urgent' THEN 1 
                    WHEN 'high' THEN 2 
                    WHEN 'normal' THEN 3 
                    WHEN 'low' THEN 4 
                    ELSE 5 
                END"
            )
            ->orderBy('order')
            ->orderBy('created_at', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_published', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function isActive(): bool
    {
        return $this->is_published && !$this->isExpired();
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'info' => 'blue',
            'warning' => 'yellow',
            'success' => 'green',
            'danger' => 'red',
            default => 'gray',
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'urgent' => 'Срочно',
            'high' => 'Высокий',
            'normal' => 'Обычный',
            'low' => 'Низкий',
            default => 'Обычный',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'info' => 'Информация',
            'warning' => 'Предупреждение',
            'success' => 'Успех',
            'danger' => 'Важно',
            default => 'Информация',
        };
    }

 
    public function hasAllLanguages(): bool
    {
        if (!$this->is_multilang) {
            return true;
        }
        
        try {
            $titleData = json_decode($this->getRawOriginal('title'), true);
            $contentData = json_decode($this->getRawOriginal('content'), true);
            
            $languages = ['ru', 'kk', 'en'];
            $hasAll = true;
            
            foreach ($languages as $lang) {
                if (empty($titleData[$lang] ?? '') || empty($contentData[$lang] ?? '')) {
                    $hasAll = false;
                    break;
                }
            }
            
            return $hasAll;
        } catch (\Exception $e) {
            return false;
        }
    }
}