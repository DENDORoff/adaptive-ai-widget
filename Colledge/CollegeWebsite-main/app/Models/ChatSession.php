<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    protected $fillable = [
        'session_id',
        'user_name',
        'user_email',
        'user_ip',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function ($session) {
            $session->messages()->delete();
        });
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id', 'session_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'session_id', 'session_id')->latest();
    }

    public function unreadMessages()
    {
        return $this->messages()->where('is_admin', false)->where('is_read', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHasUnread($query)
    {
        return $query->whereHas('messages', function ($q) {
            $q->where('is_admin', false)->where('is_read', false);
        });
    }
}