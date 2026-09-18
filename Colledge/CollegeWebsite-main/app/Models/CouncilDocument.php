<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouncilDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'council_id',
        'name',
        'file_path',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'order' => 'integer',
    ];

 
    public function council(): BelongsTo
    {
        return $this->belongsTo(Council::class);
    }


    public function getFileUrlAttribute(): ?string
    {
        if (!empty($this->file_path) && \Storage::disk('public_files')->exists($this->file_path)) {
            return \Storage::disk('public_files')->url($this->file_path);
        }
        return null;
    }


    public function fileExists(): bool
    {
        return !empty($this->file_path) && \Storage::disk('public_files')->exists($this->file_path);
    }


    public function getFileSizeAttribute(): ?string
    {
        if (!$this->fileExists()) {
            return null;
        }
        
        $size = \Storage::disk('public_files')->size($this->file_path);
        
        if ($size >= 1048576) {
            return round($size / 1048576, 1) . ' МБ';
        } elseif ($size >= 1024) {
            return round($size / 1024, 1) . ' КБ';
        } else {
            return $size . ' Б';
        }
    }


    public function getFileNameAttribute(): string
    {
        return basename($this->file_path);
    }


    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }


    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }


    public function getFileIconAttribute(): string
    {
        $extension = strtolower($this->getFileExtensionAttribute());
        
        $icons = [
            'pdf' => 'fas fa-file-pdf text-red-500',
            'doc' => 'fas fa-file-word text-blue-500',
            'docx' => 'fas fa-file-word text-blue-500',
            'xls' => 'fas fa-file-excel text-green-500',
            'xlsx' => 'fas fa-file-excel text-green-500',
            'ppt' => 'fas fa-file-powerpoint text-orange-500',
            'pptx' => 'fas fa-file-powerpoint text-orange-500',
            'jpg' => 'fas fa-file-image text-yellow-500',
            'jpeg' => 'fas fa-file-image text-yellow-500',
            'png' => 'fas fa-file-image text-yellow-500',
            'zip' => 'fas fa-file-archive text-purple-500',
            'rar' => 'fas fa-file-archive text-purple-500',
        ];
        
        return $icons[$extension] ?? 'fas fa-file text-gray-500';
    }


    public function getVisibilityBadgeAttribute(): string
    {
        if ($this->is_visible) {
            return "<span class='px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800'>Видимый</span>";
        } else {
            return "<span class='px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800'>Скрытый</span>";
        }
    }
}