<?php

namespace App\Http\Livewire;

use App\Models\Feedback;
use Livewire\Component;

class Welcome extends Component
{
    public $email;
    public $message;
    public function sendFeedBack()
    {
        $validatedData = $this->validate([
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Feedback::create($validatedData);

        $this->email = "";
        $this->message = "";
        session()->flash('info', [
            'type' => 'success',
            'message' => 'Thanks for your feedback!'
        ]);
    }
    public function render()
    {
        return view('livewire.welcome');
    }
}