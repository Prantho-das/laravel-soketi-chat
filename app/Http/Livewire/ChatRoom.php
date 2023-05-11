<?php

namespace App\Http\Livewire;

use App\Models\ChatRoom as ModelsChatRoom;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class ChatRoom extends Component
{
    public $rooms;
    public $name;
    public $description;
    public $password;

    public function createRoom()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'password' => 'required',
        ]);
        ModelsChatRoom::create([
            'name' => $this->name,
            'banner' => env('AVATAR_URL') . $this->name . '.png',
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'created_by' => auth()->id(),
            'password' => Hash::make($this->password)
        ]);

        $this->name = '';
        $this->description = '';
        $this->password = '';

        session()->flash('info', [
            'message' => 'Room Created Successfully',
            'type' => 'success',
        ]);
    }
    public function mount()
    {
        $rooms = ModelsChatRoom::query();
        if (request()->room == 'mine') {
            $rooms->where('created_by', auth()->id());
        }
        $this->rooms = $rooms->get();
    }
    public function render()
    {
        return view('livewire.chat-room');
    }
}
