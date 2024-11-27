<?php

namespace App\Models;

use App\Traits\ChatHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory, ChatHelpers;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'last_time_message',
        'group_id',
        'group_name',
    ];

    /**
     * Messages related to the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    /**
     * Members of the conversation (many-to-many relationship with EmployeeDetails).
     */
    public function members()
    {
        return $this->belongsToMany(
            EmployeeDetails::class,
            'group_conversations', // Pivot table name
            'conversation_id',     // Foreign key on pivot table
            'emp_id'               // Related key on pivot table
        );
    }
   
}
