<?php

namespace App\Http\Livewire;

use App\Models\ChatRoom as ModelsChatRoom;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ChatRoom extends Component
{use WithPagination;

    public $name;
    public $description;
    public $password;
    public $roomIsMine = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function createRoom()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'password' => 'required',
        ]);
        $group = ModelsChatRoom::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'created_by' => auth()->id(),
            'banner' => env('AVATAR_URL') . $this->name . '.png',
            'password' => Hash::make($this->password),
        ]);
        GroupUser::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_avatar' => auth()->user()->avatar,
            'joined_at' => now(),
        ]);
        $this->name = '';
        $this->description = '';
        $this->password = '';
        $this->emit('refreshComponent');
        session()->flash('info', [
            'message' => 'Room Created Successfully',
            'type' => 'success',
        ]);
    }
    public function mount()
    {
        $this->roomIsMine = request()->room == 'mine';
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function render()
    {
        $rooms = ModelsChatRoom::query();
        if ($this->roomIsMine) {
            $rooms->where('created_by', auth()->id());
        }

        return view('livewire.chat-room', [
            'rooms' => $rooms->paginate(),
        ]);
    }
}