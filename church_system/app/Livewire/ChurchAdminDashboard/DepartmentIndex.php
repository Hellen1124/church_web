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

    // Delete Modal Properties
    public $showDeleteModal = false;
    public $departmentToDelete = null;
    public $deleteConfirmation = '';
    public $deleteError = '';

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
     * Show the delete confirmation modal
     */
    public function showDeleteModal($departmentId)
    {
        $this->departmentToDelete = Department::with(['leader', 'members'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->find($departmentId);
            
        if (!$this->departmentToDelete) {
            // Department not found or doesn't belong to this tenant
            session()->flash('error', 'Department not found.');
            return;
        }
        
        $this->showDeleteModal = true;
        $this->deleteConfirmation = '';
        $this->deleteError = '';
    }

    /**
     * Close the delete modal
     */
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->departmentToDelete = null;
        $this->deleteConfirmation = '';
        $this->deleteError = '';
    }

    /**
     * Delete the department after confirmation
     */
    public function deleteDepartment()
    {
        // Validate confirmation
        if ($this->deleteConfirmation !== 'DELETE') {
            $this->deleteError = 'Please type DELETE to confirm deletion.';
            return;
        }

        if (!$this->departmentToDelete) {
            $this->deleteError = 'Department not found.';
            return;
        }

        try {
            // Check if department has members
            $memberCount = $this->departmentToDelete->members()->count();
            
            // Delete the department
            $departmentName = $this->departmentToDelete->name;
            $this->departmentToDelete->delete();
            
            // Close modal and show success message
            $this->closeDeleteModal();
            
            // Show success message
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Department Deleted',
                'message' => "Department '{$departmentName}' has been successfully deleted." . 
                            ($memberCount > 0 ? " {$memberCount} members were removed from this department." : '')
            ]);
            
            // Reset page to ensure we don't show empty page if last item deleted
            $this->resetPage();
            
        } catch (\Exception $e) {
            $this->deleteError = 'An error occurred while deleting the department. Please try again.';
            logger()->error('Department deletion error: ' . $e->getMessage());
        }
    }

    /**
     * Reset delete confirmation error when user types
     */
    public function updatedDeleteConfirmation()
    {
        $this->deleteError = '';
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
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('leader', function ($subQuery) {
                          $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                                   ->orWhere('last_name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'All', function ($query) {
                // Filter by Status unless 'All' is selected
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.church-admin-dashboard.department-index', [
            'departments' => $departments,
        ]);
    }
}