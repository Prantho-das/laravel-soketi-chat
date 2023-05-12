<?php

namespace App\Http\Livewire\Components\Common;

use Livewire\Component;

class Header extends Component
{
    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.components.common.header');
    }
}