<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDocument extends Model
{
    use HasFactory;


    protected $table = 'service_documents';

    protected $fillable = [
        'government_service_id',
        'name',
        'file_path',
        'document_type',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'order' => 'integer',
    ];


    protected $documentTypeLabels = [
        'info' => 'Информационный',
        'form' => 'Форма/Бланк',
        'regulation' => 'Регламент',
        'instruction' => 'Инструкция',
        'other' => 'Другое',
    ];

 
    public function governmentService(): BelongsTo
    {
        return $this->belongsTo(GovernmentService::class, 'government_service_id');
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


    public function getDocumentTypeLabelAttribute(): string
    {
        return $this->documentTypeLabels[$this->document_type] ?? 'Неизвестно';
    }


    public function getDocumentTypeIconAttribute(): string
    {
        $icons = [
            'info' => 'fas fa-info-circle',
            'form' => 'fas fa-file-alt',
            'regulation' => 'fas fa-book',
            'instruction' => 'fas fa-list-check',
            'other' => 'fas fa-file',
        ];
        
        return $icons[$this->document_type] ?? 'fas fa-file';
    }


    public function getDocumentTypeColorAttribute(): string
    {
        $colors = [
            'info' => 'blue',
            'form' => 'green',
            'regulation' => 'purple',
            'instruction' => 'orange',
            'other' => 'gray',
        ];
        
        return $colors[$this->document_type] ?? 'gray';
    }

 
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }


    public function getFormattedDocumentTypeAttribute(): string
    {
        $badgeColors = [
            'info' => 'bg-blue-100 text-blue-800',
            'form' => 'bg-green-100 text-green-800',
            'regulation' => 'bg-purple-100 text-purple-800',
            'instruction' => 'bg-orange-100 text-orange-800',
            'other' => 'bg-gray-100 text-gray-800',
        ];

        $color = $badgeColors[$this->document_type] ?? 'bg-gray-100 text-gray-800';
        $label = $this->getDocumentTypeLabelAttribute();

        return "<span class='px-2 py-1 text-xs font-medium rounded-full $color'>$label</span>";
    }
}