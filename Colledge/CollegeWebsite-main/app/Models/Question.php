<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'question',
        'answer',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}