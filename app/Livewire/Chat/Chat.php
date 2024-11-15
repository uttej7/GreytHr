<?php

namespace App\Livewire\Chat;

use App\Models\Chating;
use App\Models\Message;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
// use Hashids\Hashids;
// use Hashids;
use Vinkla\Hashids\Facades\Hashids;

class Chat extends Component
{
    public $query;
    public $selectedConversation;

    public function mount($query)
    {
        try {
            // $hashids = new Hashids('default-salt', 50); // Initialize with the same salt and minimum length
            // Decode the query string
            $decodedIds = Hashids::decode($query);
            if (empty($decodedIds)) {
                session()->flash('connection error');
                // Handle case where the decoding returns an empty array
            }

            // Fetch the conversation using the decoded ID
            $this->selectedConversation = Chating::find($decodedIds[0]);
            if (!$this->selectedConversation) {
                // Handle case where the conversation is not found
                session()->flash('connection error');
            }
            // Mark messages belonging to receiver as read
            Message::where('chating_id', $this->selectedConversation->id)
                ->where('receiver_id', auth()->user()->emp_id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            Notification::where('chatting_id', $this->selectedConversation->id)
                ->where('receiver_id', auth()->user()->emp_id)
                ->whereNull('message_read_at')
                ->update(['message_read_at' => now()]);
        } catch (\Exception $e) {
            // Handle other potential errors
            throw $e;
        }
    }
    public function render()
    {
        return view('livewire.chat.chat');
    }
}
