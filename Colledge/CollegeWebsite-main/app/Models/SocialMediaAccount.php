<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    protected $fillable = [
        'platform',
        'account_url',
        'api_key',
        'followers_count',
        'previous_followers_count',
        'growth_percentage',
        'auto_update',
        'last_synced_at',
        'is_active',
    ];

    protected $casts = [
        'auto_update' => 'boolean',
        'is_active' => 'boolean',
        'growth_percentage' => 'decimal:2',
        'last_synced_at' => 'datetime',
    ];

  
    public function calculateGrowth(): void
    {
        if ($this->previous_followers_count == 0) {
            $this->growth_percentage = 100;
            return;
        }

        $this->growth_percentage = round(
            (($this->followers_count - $this->previous_followers_count) / $this->previous_followers_count) * 100,
            2
        );
    }

   
    public function updateFollowers(int $newCount): void
    {
        $this->previous_followers_count = $this->followers_count;
        $this->followers_count = $newCount;
        $this->calculateGrowth();
        $this->last_synced_at = now();
        $this->save();

        
        $this->updateDashboardStatistic();
    }

   
    protected function updateDashboardStatistic(): void
    {
        $statKey = match($this->platform) {
            'telegram' => 'ideology_social_telegram',
            'instagram' => 'ideology_social_instagram',
            'youtube' => 'ideology_social_youtube',
            default => null,
        };

        if ($statKey) {
            $stat = DashboardStatistic::where('key', $statKey)->first();
            if ($stat) {
                $stat->updateValue(number_format($this->followers_count, 0, '', ' '));
            }
        }
    }

    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    
    public function scopeAutoUpdate($query)
    {
        return $query->where('auto_update', true);
    }

    
    public function getPlatformIconAttribute(): string
    {
        return match($this->platform) {
            'telegram' => 'fab fa-telegram',
            'instagram' => 'fab fa-instagram',
            'youtube' => 'fab fa-youtube',
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fab fa-twitter',
            default => 'fas fa-globe',
        };
    }

    
    public function getPlatformColorAttribute(): string
    {
        return match($this->platform) {
            'telegram' => '#0088cc',
            'instagram' => '#E4405F',
            'youtube' => '#FF0000',
            'facebook' => '#1877F2',
            'twitter' => '#1DA1F2',
            default => '#6B7280',
        };
    }
}