<?php


namespace App\Livewire\SuperAdminUsers;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;
    
    public $search = '';
    public $tenantFilter = '';
    public $roleFilter = '';
    public $perPage = 25;
    
    // Use the default Livewire 3 property update hook instead of $listeners for search
    // protected $listeners = ['refreshUserTable' => '$refresh']; 

    // Reset pagination whenever a filter or search term changes
    public function updated($property)
    {
        if (in_array($property, ['search', 'tenantFilter', 'roleFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    // Method for the impersonation action
    public function impersonate($userId)
    {
        // Add a check to prevent impersonating yourself or other super admins, if needed
        $userToImpersonate = User::findOrFail($userId);
        
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized');
        }

        // Standard Laravel impersonation setup
        session(['impersonated_by' => auth()->id()]);
        auth()->login($userToImpersonate);

        // Livewire 3 dispatch syntax
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Now impersonating user: ' . $userToImpersonate->first_name . '!'
        ]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        $users = User::with(['tenant', 'roles'])
            // Search logic: checks first_name, last_name, email, and tenant's church_name
            ->when($this->search, function($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhereHas('tenant', function ($q) {
                      $q->where('church_name', 'like', "%{$this->search}%");
                  });
            })
            // Filter by Tenant ID
            ->when($this->tenantFilter, fn($q) => $q->where('tenant_id', $this->tenantFilter))
            // Filter by Role Name
            ->when($this->roleFilter, fn($q) => $q->whereHas('roles', fn($q) => $q->where('name', $this->roleFilter)))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.super-admin-users.user-table', [
            'users' => $users,
        ]);
    }
}
