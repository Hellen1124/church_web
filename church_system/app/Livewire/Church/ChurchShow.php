<?php

namespace App\Livewire\Church;

use Livewire\Component;
use App\Models\Tenant;

class ChurchShow extends Component
{
    public Tenant $church;

    public function mount(Tenant $church)
    {
        $this->church = $church;
    }

    public function toggleStatus()
    {
        $this->church->update(['is_active' => !$this->church->is_active]);
        session()->flash('success', 'Church status updated successfully.');
    }

    public function render()
    {
        return view('livewire.church.church-show');
    }
}
