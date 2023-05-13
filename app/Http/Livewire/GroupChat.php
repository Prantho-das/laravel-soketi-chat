<?php

namespace App\Http\Livewire;

use App\Events\SendGroupMessage;
use App\Models\ChatRoom;
use App\Models\GroupUser;
use App\Models\Message;
use Livewire\Component;

class GroupChat extends Component
{
    public $message;
    public $messageList = [];
    public $groupInfo;
    public $auth;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']

    protected function getListeners()
    {
        $groupId = $this->groupInfo['id'];
        return ["echo-private:soketiGroup.{$groupId},SendGroupMessage" => 'newMessage'];
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
            'group_id' => $this->groupInfo['id'],
        ];

        broadcast(new SendGroupMessage($message));
        Message::create([
            'room_id' => $this->groupInfo['id'],
            'sender_id' => $this->auth['id'],
            'message' => $this->message ?? '',
            'asset_link' => '',
        ]);
        $this->message = '';

    }

    public function newMessage($event)
    {
        $this->messageList[] = [
            'message' => $event['message'],
            'image' => $event['image'],
            'sender_id' => $event['sender_id'],
            'sender_name' => $event['sender_name'],
            'sender_avatar' => $event['sender_avatar'],
            'group_id' => $event['group_id'],
        ];
        $this->emit('messageSentRefresh', $event['sender_id'] == $this->auth->id);

    }
    public function mount($roomId)
    {
        $this->groupInfo = ChatRoom::where('slug', $roomId)->firstOrFail();
        $this->auth = auth()->user();
        if (!GroupUser::where('group_id', $this->groupInfo['id'])->where('user_id', $this->auth->id)->exists()) {
            abort(403, 'You are not allowed to view this page');
        }
        $serverMessage = Message::where('room_id', $this->groupInfo['id'])->get();
        foreach ($serverMessage as $key => $value) {
            $this->messageList[] = [
                'message' => $value['message'],
                'image' => $value['image'],
                'sender_id' => $value['sender_id'],
                'sender_name' => $value->sender->name ?? '',
                'sender_avatar' => $value->sender->avatar ?? env('AVATAR_URL') . 'default.png',
                'group_id' => $value['room_id'],
            ];
        }
    }
    public function render()
    {
        return view('livewire.group-chat');
    }
}