<?php


namespace App\Livewire\ChurchAdminDashboard;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class UserIndex extends Component
{
    use WithPagination;

    // Search properties
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        // 1. Authorization Check for Viewing Users
        if (Gate::denies('view users')) {
            // If the user lacks the permission, render a forbidden view or redirect
            abort(403, 'You do not have permission to view users.');
        }

        // Get the current tenant ID
        $currentTenantId = auth()->user()->tenant_id;

        // 2. Tenant-Scoped Query
        $users = User::query()
            // CRITICAL: Filter users only by the current tenant ID
            ->where('tenant_id', $currentTenantId)
            
            // Apply search filtering (searches first name, last name, and email)
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            // Apply sorting
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.church-admin-dashboard.user-index', [
            'users' => $users,
        ]);
    }
    
    // --- Actions for Delete (Requires Policy/Gate check) ---
    public function deleteUser(User $user)
    {
        // Double-check: Admin must have permission AND the user must be in the same tenant
        if (Gate::allows('delete users') && $user->tenant_id === auth()->user()->tenant_id) {
            $user->delete();
            $this->notification()->success(
                $title = 'User Deleted',
                $description = "The user has been successfully removed from this church."
            );
        } else {
            $this->notification()->error(
                $title = 'Authorization Failed',
                $description = 'You are not authorized to delete this specific user.'
            );
        }
    }
}
