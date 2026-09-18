<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'file_path',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }


    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }


    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }


    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }


    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'danger',
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'gray',
        };
    }


    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'new' => 'Новое',
            'in_progress' => 'В работе',
            'completed' => 'Завершено',
            default => 'Неизвестно',
        };
    }
}