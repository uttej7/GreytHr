<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Livewire\Component;

class ChatSendMessage extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body='';
    public $media;
    public $createdMessage;
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent', 'resetComponent'];
    public function resetComponent()
    {

        $this->selectedConversation = null;
        $this->receiverInstance = null;

        # code...
    }

    function updateSendMessage(Conversation $conversation, EmployeeDetails $receiver)
    {

        //  dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        # code...
    }


    public function sendMessage()
    {
        // Prevent sending empty messages
        if (!$this->body && !$this->media) {
            return;
        }

        $mediaPath = null;
        $mediaType = null;

        // Handle media upload
        if ($this->media) {
            $mediaPath = $this->media->store('uploads/messages', 'public');
            $mimeType = $this->media->getMimeType();

            if (str_contains($mimeType, 'image')) {
                $mediaType = 'image';
            } elseif (str_contains($mimeType, 'video')) {
                $mediaType = 'video';
            } else {
                $mediaType = 'file'; // For other types of files
            }

            // If only media is sent, set the body to indicate the type of media
            if (!$this->body) {
                $this->body = ucfirst($mediaType) . ' sent';
            }
        }

        // Create the message
        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverInstance->emp_id,
            'body' => $this->body,
            'media_path' => $mediaPath,
            'type' => $mediaType,
        ]);

        // If sender and receiver are the same, mark the message as read
        if (auth()->id() === $this->receiverInstance->emp_id) {
            $this->createdMessage->read = 1;
            $this->createdMessage->save();
        }

        // Update the conversation's last message timestamp
        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();

        // Dispatch events and reset input fields
        $this->dispatch('pushMessage', $this->createdMessage->id);
        $this->dispatch('refresh');
        $this->reset('body');
        $this->dispatch('dispatchMessageSent');
    }

    public function dispatchMessageSent()
    {

        broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
        # code...
    }
    public function render()
    {
        return view('livewire.chat.chat-send-message');
    }
}
