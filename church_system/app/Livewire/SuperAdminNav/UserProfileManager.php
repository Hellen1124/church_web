<?php

namespace App\Livewire\SuperAdminNav;


use Livewire\Component;

class UserProfileManager extends Component
{
    // Sets the default active tab to 'general' when the page loads
    public string $activeTab = 'general'; 

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
    
    public function render()
    {
        return view('livewire.super-admin-nav.user-profile-manager'); 
    }
}
