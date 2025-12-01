<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;


class MemberIndex extends Component
{
    use WithPagination;

    // State properties for filtering and searching
    public $search = '';
    public $statusFilter = '';
    public $roleFilter = '';
    public $perPage = 10;

    // Available filters (These should align with your Member model data)
    public $statuses = ['Active', 'Inactive', 'Pending'];
    public $roles = ['Member', 'Deacon', 'Pastor', 'Volunteer']; 

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        // Reset pagination when search or filters change
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Assuming the authenticated user object has 'tenant_id'
        $tenantId = Auth::user()->tenant_id;

        $members = Member::where('tenant_id', $tenantId)
            ->when($this->search, function ($query) {
                // Search across first name, last name, and membership number
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                             ->orWhere('last_name', 'like', '%' . $this->search . '%')
                             ->orWhere('membership_no', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            // Sort by the date joined (newest first)
            ->orderBy('date_joined', 'desc') 
            ->paginate($this->perPage);

        return view('livewire.church-admin-dashboard.member-index', [
            'members' => $members,
        ]);
    }

    // Utility function to reset all filters
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'roleFilter']);
        $this->resetPage();
    }
}
