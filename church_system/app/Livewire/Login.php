<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login')
            ->layout('layouts.login'); // 👈 ensure it wraps inside your login layout
    }
}
