<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'pdf_file',
        'is_active',
        'order',
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


    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }


    public function getPdfUrlAttribute()
    {
        if (!$this->pdf_file) {
            return null;
        }
        

        if (file_exists(public_path('uploads/' . $this->pdf_file))) {
            return asset('uploads/' . $this->pdf_file);
        }
        
        return asset('storage/' . $this->pdf_file);
    }


    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'charter' => 'Устав колледжа',
            'license' => 'Лицензия',
            'rules' => 'Правила внутреннего распорядка',
            default => 'Документ',
        };
    }
}