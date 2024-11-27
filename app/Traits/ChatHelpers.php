<?php

namespace App\Traits;

use App\Models\EmployeeDetails;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ChatHelpers
{
    /**
     * Get the last message for the conversation.
     *
     * @return \App\Models\Message|null
     */
    public function getLastMessage()
    {
        if (method_exists($this, 'messages')) {
            return $this->messages()->latest('last_time_message')->first();
        }

        // Return null or handle the case where 'messages' method does not exist
        return null;
    }

    /**
     * Check if the message or conversation is unread.
     *
     * @return bool
     */
    public function isUnread()
    {
        // Check if the 'read' property exists
        if (property_exists($this, 'read')) {
            return !$this->read;
        }

        // Return false or handle the case where 'read' property does not exist
        return false;
    }

    /**
     * Add a member to a conversation (e.g., for group chats).
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function addMember($user)
    {
        if (method_exists($this, 'members')) {
            return $this->members()->attach($user->id);
        }

        // Return false or log an error if 'members' method does not exist
        return false;
    }

    /**
     * Remove a member from a conversation (e.g., for group chats).
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function removeMember($user)
    {
        if (method_exists($this, 'members')) {
            return $this->members()->detach($user->id);
        }

        // Return false or log an error if 'members' method does not exist
        return false;
    }

    /**
     * Mark all messages in the conversation as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (method_exists($this, 'messages')) {
            $this->messages()->update(['read' => true]);
            return;
        }

        if (property_exists($this, 'read')) {
            $this->update(['read' => true]);
            return;
        }

        // Optionally, handle the case where neither 'messages' nor 'read' property exists
    }

    /**
     * Get all unread messages in the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadMessages()
    {
        if (method_exists($this, 'messages')) {
            return $this->messages()->where('read', false)->get();
        }

        // Return an empty collection or handle the case where 'messages' method does not exist
        return collect();
    }

    /**
     * Check if the user is online based on their last activity timestamp.
     *
     * @return bool
     */
    public function isOnline()
    {
        if (property_exists($this, 'last_activity')) {
            return Carbon::parse($this->last_activity)->greaterThan(Carbon::now()->subMinutes(5));
        }

        return false;
    }

    /**
     * Get the user's avatar URL, or use a default avatar if none exists.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/images/avatarr-default.jpeg');
    }

    /**
     * Get whether the user is online based on the 'last_seen' timestamp.
     *
     * @return bool
     */
    public function getIsOnlineAttribute()
    {
        return $this->last_seen && Carbon::parse($this->last_seen)->diffInMinutes(now()) <= 5;
    }

    /**
     * Get the count of unread messages for the current conversation.
     *
     * @return int
     */
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where(function ($query) use ($userId) {
                $query->where('receiver_id', $userId) // Messages sent to the user
                      ->orWhere('receiver_id', auth()->id()); // Include auth user as receiver
            })
            ->where('read', false) // Only unread messages
            ->count();
    }




    /**
     * Define the 'messages' relationship, assuming it's a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'emp_id');
    }


    /**
     * Define the 'members' relationship, assuming it's a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(EmployeeDetails::class, 'group_conversations', 'conversation_id', 'emp_id');
    }

    public function sender()
    {
        return $this->belongsTo(EmployeeDetails::class, 'sender_id', 'emp_id');
    }

    public function receiver()
    {
        return $this->belongsTo(EmployeeDetails::class, 'receiver_id', 'emp_id');
    }
}
