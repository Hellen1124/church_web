<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use WireUi\Traits\WireUiActions;


class Home extends Component
{

    use WireUiActions;
    
  public function render()
    {
        $role = auth()->user()->getRoleNames()->first();
        return view('livewire.dashboard.home', ['role' => $role])
            ->layout('layouts.dashboard');
    }
}


   

