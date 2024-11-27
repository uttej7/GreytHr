<?php

namespace App\Livewire\Chat;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;

class ChatBox extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $messages;
    public $newMessage;
    public $media;
    public $receiverId;
    public $selectedConversation;
    public $messages_count;
    public $receiver;
    public $paginateVar = 10;
    public $height;
    public $receiverInstance;
    public $body = '';
    public $createdMessage;
    protected $listeners = ['loadConversation', 'updateSendMessage', 'dispatchMessageSent', 'resetComponent'];

    // protected $listeners = [ 'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', "echo-private:chat. {$auth_id},MessageSent"=>'broadcastedMessageReceived',];
    public function  getListeners()
    {

        $auth_id = auth()->user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
            'loadConversation',
            'pushMessage',
            'loadmore',
            'updateHeight',
            'broadcastMessageRead',
            'resetComponent'
        ];
    }



    public function resetComponent()
    {

        $this->selectedConversation = null;
    }

    public function broadcastedMessageRead($event)
    {

        if ($this->selectedConversation) {



            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']) {

                $this->dispatch('markMessageAsRead');
            }
        }

        # code...
    }
    /*---------------------------------------------------------------------------------------*/
    /*-----------------------------Broadcasted Event fucntion-------------------------------------------*/
    /*----------------------------------------------------------------------------*/

    function broadcastedMessageReceived($event)
    {
        ///here
        $this->dispatch('refresh');
        # code...

        $broadcastedMessage = Message::find($event['message']);


        #check if any selected conversation is set
        if ($this->selectedConversation) {
            #check if Auth/current selected conversation is same as broadcasted selecetedConversationgfg
            if ((int) $this->selectedConversation->id  === (int)$event['conversation_id']) {
                # if true  mark message as read
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();
                $this->pushMessage($broadcastedMessage->id);
                // dd($event);

                $this->dispatch('broadcastMessageRead');
            }
        }
    }


    public function broadcastMessageRead()
    {
        broadcast(new MessageRead($this->selectedConversation->id, $this->receiverInstance->emp_id));
        # code...
    }

    /*--------------------------------------------------*/
    /*------------------push message to chat--------------*/
    /*------------------------------------------------ */
    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatch('rowChatToBottom');
        # code...
    }



    /*--------------------------------------------------*/
    /*------------------load More --------------------*/
    /*------------------------------------------------ */
    function loadmore()
    {

        //  dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatch('updatedHeight', ($height));
        # code...
    }


    /*---------------------------------------------------------------------*/
    /*------------------Update height of messageBody-----------------------*/
    /*---------------------------------------------------------------------*/
    function updateHeight($height)
    {

        // dd($height);
        $this->height = $height;

        # code...
    }



    /*---------------------------------------------------------------------*/
    /*------------------load conersation----------------------------------*/
    /*---------------------------------------------------------------------*/
    public function loadConversation(Conversation $conversation, EmployeeDetails $receiver)
    {
        $this->selectedConversation =  $conversation;
        $this->receiverInstance =  $receiver;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();
        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id',  auth()->id())->update(['read' => 1]);
        $this->dispatch('chatSelected');

        $this->dispatch('broadcastMessageRead');
        # code...
    }

    // function updateSendMessage(Conversation $conversation, EmployeeDetails $receiver)
    // {

    //     //  dd($conversation,$receiver);
    //     $this->selectedConversation = $conversation;
    //     $this->receiverInstance = $receiver;
    //     # code...
    // }




    // public function sendMessage()
    // {
    //     // Prevent sending empty messages
    //     if (!$this->body && !$this->media) {
    //         return;
    //     }

    //     $mediaPath = null;
    //     $mediaType = null;

    //     // Handle media upload
    //     if ($this->media) {
    //         $mediaPath = $this->media->store('uploads/messages', 'public');
    //         $mimeType = $this->media->getMimeType();

    //         if (str_contains($mimeType, 'image')) {
    //             $mediaType = 'image';
    //         } elseif (str_contains($mimeType, 'video')) {
    //             $mediaType = 'video';
    //         } else {
    //             $mediaType = 'file'; // For other types of files
    //         }

    //         // If only media is sent, set the body to indicate the type of media
    //         if (!$this->body) {
    //             $this->body = ucfirst($mediaType) . ' sent';
    //         }
    //     }

    //     // Create the message
    //     $this->createdMessage = Message::create([
    //         'conversation_id' => $this->selectedConversation->id,
    //         'sender_id' => auth()->id(),
    //         'receiver_id' => $this->receiverInstance->emp_id,
    //         'body' => $this->body,
    //         'media_path' => $mediaPath,
    //         'type' => $mediaType,
    //     ]);

    //     // If sender and receiver are the same, mark the message as read
    //     if (auth()->id() === $this->receiverInstance->emp_id) {
    //         $this->createdMessage->read = 1;
    //         $this->createdMessage->save();
    //     }

    //     // Update the conversation's last message timestamp
    //     $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
    //     $this->selectedConversation->save();

    //     // Dispatch events and reset input fields
    //     $this->dispatch('pushMessage', $this->createdMessage->id);
    //     $this->dispatch('refresh');
    //     $this->reset('body');
    //     $this->body = '';
    //     $this->dispatch('dispatchMessageSent');
    // }




    // public function dispatchMessageSent()
    // {

    //     dd('hello world');
    //     broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
    //     # code...
    // }


    public function render()
    {
        return view('livewire.chat.chat-box', [
            'messages' => $this->messages,
            'conversationId' => $this->conversationId,
            'receiverInstance' => $this->receiverInstance
        ]);
    }
}
