<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLessons($query)
    {
        return $query->where('type', 'lessons');
    }

    public function scopeBells($query)
    {
        return $query->where('type', 'bells');
    }

    public function getFileUrlAttribute()
    {
        if (file_exists(public_path('uploads/' . $this->file_path))) {
            return asset('uploads/' . $this->file_path);
        }
        return asset('storage/' . $this->file_path);
    }
}