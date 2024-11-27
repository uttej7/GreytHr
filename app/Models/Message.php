<?php

namespace App\Models;

use App\Traits\ChatHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, ChatHelpers;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'last_time_message',
        'conversation_id',
        'read',
        'body',
        'type',
        'media_path'
    ];

    /**
     * The conversation this message belongs to.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function isMedia()
    {
        return in_array($this->type, ['image', 'video']);
    }

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }
}
