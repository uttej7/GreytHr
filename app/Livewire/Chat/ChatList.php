<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\EmployeeDetails;
use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $selectedConversation;
    public $search = ''; // Search query
    public $receiverInstance;
    public $name;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetComponent'];

    public function resetComponent()
    {
        $this->selectedConversation = null;
    }

    public function chatUserSelected($senderId, $receiverId)
    {
        // dd($senderId, $receiverId);
        // Fetch the conversation between the two users
        $this->selectedConversation = Conversation::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->first();
        $receiverInstance = EmployeeDetails::find($receiverId);
        $this->dispatch('loadConversation', $this->selectedConversation, $receiverInstance);
        $this->dispatch('updateSendMessage', $this->selectedConversation, $receiverInstance);

        # code...
    }

    // public function mount()
    // {

    //     $this->auth_id = auth()->id();
    //     $this->conversations = Conversation::where('sender_id', $this->auth_id)
    //         ->orWhere('receiver_id', $this->auth_id)->orderBy('last_time_message', 'DESC')->get();

    //     # code...
    // }
    public function render()
    {
        // Get the authenticated user's ID
        $this->auth_id = auth()->id();

        // Fetch conversations with related employee details
        $this->conversations = Conversation::with(['sender', 'receiver'])
            ->where(function ($query) {
                $query->where('sender_id', $this->auth_id)
                    ->orWhere('receiver_id', $this->auth_id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('sender', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('job_role', 'like', '%' . $this->search . '%');
                })->orWhereHas('receiver', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('job_role', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('last_time_message', 'DESC') // Assuming conversations have a field to track the last message time
            ->get();

        // Filter conversations to only include those with employees matching the search
        $this->conversations = $this->conversations->filter(function ($conversation) {
            return $conversation->sender->first_name || $conversation->receiver->last_name; // Filtering logic.
        });

        return view('livewire.chat.chat-list', [
            'conversations' => $this->conversations,
        ]);
    }
}
