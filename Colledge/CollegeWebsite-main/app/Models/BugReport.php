<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'page_url',
        'browser',
        'os',
        'device',
        'title',
        'description',
        'steps_to_reproduce',
        'expected_result',
        'actual_result',
        'priority',
        'status',
        'admin_comment',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'steps_to_reproduce' => 'array', 
    ];


    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }


    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }


    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }


    public function scopeNeedMoreInfo($query)
    {
        return $query->where('status', 'need_more_info');
    }


    public function scopeCannotReproduce($query)
    {
        return $query->where('status', 'cannot_reproduce');
    }


    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'danger',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'need_more_info' => 'info',
            'cannot_reproduce' => 'gray',
            default => 'gray',
        };
    }


    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'new' => 'Новое',
            'in_progress' => 'В работе',
            'resolved' => 'Решено',
            'need_more_info' => 'Требует уточнений',
            'cannot_reproduce' => 'Не воспроизводится',
            default => 'Неизвестно',
        };
    }


    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'critical' => 'danger',
            'high' => 'warning',
            'medium' => 'info',
            'low' => 'success',
            default => 'gray',
        };
    }


    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'critical' => 'Критический',
            'high' => 'Высокий',
            'medium' => 'Средний',
            'low' => 'Низкий',
            default => 'Не указан',
        };
    }


    public function getShortDescriptionAttribute()
    {
        return strlen($this->description) > 100 
            ? substr($this->description, 0, 100) . '...' 
            : $this->description;
    }
}