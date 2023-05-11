<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Authorization extends Component
{
    public $email;
    public $password;
    public $name;

    public $showRegister=false;
    public function register()
    {
        $validData = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => env('AVATAR_URL') . $this->name . '.png',
        ]);
        auth()->login($user);
        session()->flash('info', [
            'type' => 'success',
            'message' => 'Thanks for your feedback!',
        ]);
        return redirect()->to('/');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('info', [
                'type' => 'success',
                'message' => 'Thanks for your feedback!',
            ]);
            return redirect()->to('/');
        } else {
            session()->flash('error', 'Email or password is incorrect');
        }
    }
    public function render()
    {
        return view('livewire.auth.authorization');
    }
}
