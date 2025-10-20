<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tenant;
use WireUi\Traits\WireUiActions;


class ListTenants extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';

    protected $queryString = ['search'];
    protected $listeners = ['tenantUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        $this->notification()->success(
            $title = 'Tenant Deleted',
            $description = 'Tenant has been successfully removed.'
        );
    }

    public function render()
    {
        $tenants = Tenant::query()
            ->where('name', 'like', "%{$this->search}%")
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.tenant.list-tenants', compact('tenants'));
    }
}

