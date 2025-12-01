<?php

namespace App\Livewire\ChurchAdminDashboard;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // To fetch available leaders

class DepartmentIndex extends Component
{
    use WithPagination;

    // --- Component State (Public Properties) ---
    
    // For Search functionality
    public $search = '';

    // For Status filtering (Active, Inactive, All)
    public $statusFilter = 'Active';

    // For Sorting
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    // Status options for the filter dropdown
    public $statuses = ['Active', 'Inactive', 'All']; 

    /**
     * Resets the pagination when search or filters change.
     */
    public function updating($key)
    {
        // Check if the property being updated is related to data fetching
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    /**
     * Logic to toggle the sorting direction.
     */
    public function setSortBy($field)
    {
        if ($this->sortBy === $field) {
            // Toggle direction if clicking the same column
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Set new column and default to 'asc'
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * The main data rendering method.
     */
    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        
        $departments = Department::with('leader')
            ->where('tenant_id', $tenantId)
            ->when($this->search, function ($query) {
                // Search by Department Name or Leader Name
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('leader', function ($subQuery) {
                          $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                                   ->orWhere('last_name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->statusFilter !== 'All', function ($query) {
                // Filter by Status unless 'All' is selected
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10); // Use 10 items per page for a good UX

        return view('livewire.church-admin-dashboard.department-index', [
            'departments' => $departments,
        ]);
    }
}
