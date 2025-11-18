<?php

namespace App\Livewire\SuperAdminUsers;

use Livewire\Component;

class ImpersonateModal extends Component
{
    public $showModal = false;
    public $userId;

    protected $listeners = [
        'openImpersonateModal' => 'openModal'
    ];

    public function openModal($userId)
    {
        $this->userId = $userId;
        $this->showModal = true;
    }

    public function impersonate()
    {
        if (!auth()->user()->hasRole('super-admin')) abort(403);

        session(['impersonated_by' => auth()->id()]);
        auth()->loginUsingId($this->userId);

        $this->showModal = false;

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Now impersonating user!']);
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.super-admin-users.impersonate-modal');
    }
}
