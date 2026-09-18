<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DashboardStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'category',
        'value',
        'label',
        'description',
        'previous_value',
        'growth_percentage',
        'auto_calculate_growth',
        'is_auto_updated',
        'update_source',
        'last_updated_at',
        'order',
        'is_active',
        'unit',
        'data_type',
        'show_growth',
        'is_public',
    ];

    protected $casts = [
        'auto_calculate_growth' => 'boolean',
        'is_auto_updated' => 'boolean',
        'is_active' => 'boolean',
        'show_growth' => 'boolean',
        'is_public' => 'boolean',
        'last_updated_at' => 'datetime',
        'previous_value' => 'decimal:2',
        'growth_percentage' => 'decimal:2',
        'order' => 'integer',
    ];


    public const CATEGORY_ACADEMIC = 'academic';
    public const CATEGORY_EVENTS = 'events';
    public const CATEGORY_SERVICES = 'services';
    public const CATEGORY_TECH = 'tech';


    public const SOURCE_INSTAGRAM = 'instagram';
    public const SOURCE_TELEGRAM = 'telegram';
    public const SOURCE_YOUTUBE = 'youtube';
    public const SOURCE_PORTAL_VISITS = 'portal_visits';
    public const SOURCE_BLOG_APPEALS = 'blog_appeals';
    public const SOURCE_API = 'api';
    public const SOURCE_DATABASE = 'database';
    public const SOURCE_MANUAL = 'manual';
    public const SOURCE_SYSTEM = 'system';
    public const SOURCE_EXTERNAL = 'external';


    public const DATA_TYPE_NUMBER = 'number';
    public const DATA_TYPE_PERCENTAGE = 'percentage';
    public const DATA_TYPE_CURRENCY = 'currency';
    public const DATA_TYPE_TEXT = 'text';


    protected static function booted(): void
    {
        static::saving(function (DashboardStatistic $statistic) {
            $statistic->calculateGrowth();
            
            if ($statistic->is_auto_updated) {
                $statistic->last_updated_at = now();
            }
        });

        static::saved(function (DashboardStatistic $statistic) {

            $statistic->clearDashboardCache();
        });

        static::deleted(function (DashboardStatistic $statistic) {
            $statistic->clearDashboardCache();
        });
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeAutoUpdated($query)
    {
        return $query->where('is_auto_updated', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }


    public function calculateGrowth(): void
    {
        if (!$this->auto_calculate_growth || !$this->previous_value) {
            return;
        }

        $currentValue = (float) $this->getNumericValue();
        $previousValue = (float) $this->previous_value;

        if ($previousValue == 0) {
            $this->growth_percentage = 100;
        } else {
            $this->growth_percentage = (($currentValue - $previousValue) / $previousValue) * 100;
        }
    }


    private function getNumericValue(): float
    {
        if ($this->data_type === self::DATA_TYPE_TEXT) {
            return 0;
        }

        $value = $this->value;
        
        if (is_numeric($value)) {
            return (float) $value;
        }

        $cleaned = preg_replace('/[^0-9.,]/', '', $value);
        $cleaned = str_replace(',', '.', $cleaned);
        $cleaned = str_replace(' ', '', $cleaned);
        
        return (float) $cleaned ?: 0;
    }


    public function updateValue(string $newValue): void
    {
        if ($this->auto_calculate_growth) {
            $this->previous_value = $this->getNumericValue();
        }

        $this->value = $newValue;
        $this->last_updated_at = now();
        
        $this->calculateGrowth();
        $this->save();
    }


    public function getFormattedValue(): string
    {
        $value = $this->value;
        $unit = $this->unit ?: '';
        
        if ($this->data_type === self::DATA_TYPE_PERCENTAGE) {
            return $this->formatPercentage($value) . $unit;
        }
        
        if ($this->data_type === self::DATA_TYPE_CURRENCY) {
            return $this->formatCurrency($value) . $unit;
        }
        
        if (is_numeric($value) && $this->data_type === self::DATA_TYPE_NUMBER) {
            return $this->formatNumber($value) . ($unit ? ' ' . $unit : '');
        }
        
        return $value . ($unit ? ' ' . $unit : '');
    }


    public function getFormattedGrowth(): ?string
    {
        if (!$this->growth_percentage || !$this->show_growth) {
            return null;
        }

        $sign = $this->growth_percentage > 0 ? '+' : '';
        return $sign . round($this->growth_percentage, 1) . '%';
    }


    private function formatNumber($number): string
    {
        $num = (float) $number;
        
        if ($num >= 1000000) {
            return round($num / 1000000, 1) . ' млн';
        }
        
        if ($num >= 1000) {
            return number_format($num, 0, '.', ' ');
        }
        
        return (string) $num;
    }

    private function formatPercentage($value): string
    {
        $num = (float) $value;
        return round($num, 1) . '%';
    }

    private function formatCurrency($value): string
    {
        $num = (float) $value;
        
        if ($num >= 1000000) {
            return round($num / 1000000, 1) . ' млн ₸';
        }
        
        if ($num >= 1000) {
            return number_format($num, 0, '.', ' ') . ' ₸';
        }
        
        return $num . ' ₸';
    }


    public function toApiResponse(): array
    {
        return [
            'key' => $this->key,
            'category' => $this->category,
            'value' => $this->value,
            'formatted_value' => $this->getFormattedValue(),
            'label' => $this->label,
            'description' => $this->description,
            'unit' => $this->unit,
            'data_type' => $this->data_type,
            'growth_percentage' => $this->growth_percentage,
            'formatted_growth' => $this->getFormattedGrowth(),
            'show_growth' => $this->show_growth,
            'is_auto_updated' => $this->is_auto_updated,
            'update_source' => $this->update_source,
            'last_updated_at' => $this->last_updated_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'order' => $this->order,
        ];
    }


    public static function getCachedByCategory(string $category): array
    {
        $cacheKey = "dashboard_stats_category_{$category}";
        
        return Cache::remember($cacheKey, 300, function () use ($category) {
            return self::active()
                ->public()
                ->byCategory($category)
                ->ordered()
                ->get()
                ->map(function ($stat) {
                    return $stat->toApiResponse();
                })
                ->toArray();
        });
    }


    public static function getAllCached(): array
    {
        $cacheKey = 'dashboard_stats_all';
        
        return Cache::remember($cacheKey, 300, function () {
            return self::active()
                ->public()
                ->ordered()
                ->get()
                ->map(function ($stat) {
                    return $stat->toApiResponse();
                })
                ->toArray();
        });
    }


    public function clearDashboardCache(): void
    {

        Cache::forget('dashboard_stats_all');
        
        foreach ([self::CATEGORY_ACADEMIC, self::CATEGORY_EVENTS, self::CATEGORY_SERVICES, self::CATEGORY_TECH] as $category) {
            Cache::forget("dashboard_stats_category_{$category}");
        }
    }


    public static function bulkUpdate(array $updates): void
    {
        foreach ($updates as $key => $value) {
            $statistic = self::where('key', $key)->first();
            
            if ($statistic) {
                $statistic->updateValue($value);
            }
        }
    }


    public static function getCategories(): array
    {
        return [
            self::CATEGORY_ACADEMIC => 'Академическая деятельность',
            self::CATEGORY_EVENTS => 'Идеологическая деятельность',
            self::CATEGORY_SERVICES => 'Административная деятельность',
            self::CATEGORY_TECH => 'IT Cluster',
        ];
    }

    public static function getUpdateSources(): array
    {
        return [
            self::SOURCE_INSTAGRAM => 'Instagram',
            self::SOURCE_TELEGRAM => 'Telegram',
            self::SOURCE_YOUTUBE => 'YouTube',
            self::SOURCE_PORTAL_VISITS => 'Посещения портала',
            self::SOURCE_BLOG_APPEALS => 'Обращения в блог',
            self::SOURCE_API => 'Внешний API',
            self::SOURCE_DATABASE => 'База данных',
            self::SOURCE_MANUAL => 'Ручной ввод',
            self::SOURCE_SYSTEM => 'Системный расчёт',
            self::SOURCE_EXTERNAL => 'Внешняя система',
        ];
    }

    public static function getDataTypes(): array
    {
        return [
            self::DATA_TYPE_NUMBER => 'Число',
            self::DATA_TYPE_PERCENTAGE => 'Процент',
            self::DATA_TYPE_CURRENCY => 'Валюта',
            self::DATA_TYPE_TEXT => 'Текст',
        ];
    }


    public function hasGrowth(): bool
    {
        return !is_null($this->growth_percentage) && $this->show_growth;
    }

    public function isPositiveGrowth(): bool
    {
        return $this->growth_percentage > 0;
    }

    public function isNegativeGrowth(): bool
    {
        return $this->growth_percentage < 0;
    }

    public function getGrowthColor(): string
    {
        if ($this->growth_percentage > 0) {
            return 'text-green-600';
        } elseif ($this->growth_percentage < 0) {
            return 'text-red-600';
        } else {
            return 'text-gray-600';
        }
    }

    public function getGrowthIcon(): string
    {
        if ($this->growth_percentage > 0) {
            return 'heroicon-o-arrow-trending-up';
        } elseif ($this->growth_percentage < 0) {
            return 'heroicon-o-arrow-trending-down';
        } else {
            return 'heroicon-o-minus';
        }
    }
}