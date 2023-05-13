<?php

namespace App\Http\Livewire;

use App\Events\SendSingleMessage;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class SingleMessage extends Component
{public $message;
    public $messageList = [];
    public $receiverInfo;
    public $auth;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']

    protected function getListeners()
    {
        $lisId = $this->auth->id;
        $receiverId = $this->receiverInfo->id;
        return [

            "echo-presence:soketiSingle.{$lisId},SendSingleMessage" => 'newMessage', // Listen
            // "echo-presence:soketiSingle.{$receiverId},here" => 'newMessage', // Here
            "echo-presence:soketiSingle.{$receiverId},joining" => 'activeUser', // Joining
            "echo-presence:soketiSingle.{$receiverId},leaving" => 'inActiveUser',

        ];
    }

    public function activeUser($event)
    {
        $this->receiverInfo->isActive=true;
    }
    public function inActiveUser($event)
    {
        $this->receiverInfo->isActive=false;
    }
    public function sendMessage()
    {
        $message =
            [
            'message' => $this->message ?? '',
            'image' => '',
            'sender_id' => $this->auth->id,
            'sender_name' => $this->auth->name,
            'sender_avatar' => $this->auth->avatar,
            'receiver_id' => $this->receiverInfo->id,
        ];

        $this->messageList[] = $message;
        broadcast(new SendSingleMessage($message));

        Message::create([
            'receiver_id' => $this->receiverInfo['id'],
            'sender_id' => $this->auth['id'],
            'message' => $this->message ?? '',
            'asset_link' => '',
        ]);
        $this->message = '';
        $this->emit('messageSentRefresh', true);

    }

    public function newMessage($event)
    {

        $this->messageList[] = [
            'message' => $event['message'],
            'image' => $event['image'],
            'sender_id' => $event['sender_id'],
            'sender_name' => $event['sender_name'],
            'sender_avatar' => $event['sender_avatar'],
            'receiver_id' => $event['receiver_id'],
        ];
        $this->emit('messageSentRefresh', $event['sender_id'] == $this->auth->id);

    }
    public function mount($receiverId)
    {
        $this->receiverInfo = User::findOrFail(base64_decode($receiverId));
        $this->auth = auth()->user();

        $serverMessage = Message::where(function ($query) {
            $query->where(function ($query) {
                $query->where('sender_id', $this->auth->id)->where('receiver_id', $this->receiverInfo->id);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverInfo->id)->where('receiver_id', $this->auth->id);
            });
        })
            ->get();

        foreach ($serverMessage as $key => $value) {
            $this->messageList[] = [
                'message' => $value['message'],
                'image' => $value['image'],
                'sender_id' => $value['sender_id'],
                'sender_name' => $value->sender->name ?? '',
                'sender_avatar' => $value->sender->avatar ?? env('AVATAR_URL') . 'default.png',
                'receiver_id' => $value['receiver_id'],
            ];
        }
    }
    public function render()
    {
        return view('livewire.single-message');
    }
}