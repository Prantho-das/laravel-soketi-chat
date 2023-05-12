<?php

namespace App\Http\Livewire;

use App\Models\ChatRoom as ModelsChatRoom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ChatRoom extends Component
{use WithPagination;

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
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'created_by' => auth()->id(),
            'banner' => env('AVATAR_URL') . $this->name . '.png',
            'password' => Hash::make($this->password),
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

    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function render()
    {
        $rooms = ModelsChatRoom::query();
        if (request()->room == 'mine') {
            $rooms->where('created_by', auth()->id());
        }
    
        return view('livewire.chat-room', [
            'rooms' => $rooms->paginate(),
        ]);
    }
}
