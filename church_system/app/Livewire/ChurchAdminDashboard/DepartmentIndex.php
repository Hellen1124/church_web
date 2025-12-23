<?php

namespace App\Livewire\ChurchAdminDashboard;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentIndex extends Component
{
    use WithPagination;

    // --- Component State (Public Properties) ---
    public $search = '';
    public $statusFilter = 'Active';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $statuses = ['Active', 'Inactive', 'All'];

    // --- Edit Modal Properties ---
    public $showEditModal = false;
    public $departmentId;
    public $departmentName;
    public $departmentStatus;
    public $departmentLeaderId;
    public $allLeaders;

    // --- Lifecycle Hooks & Initialization ---
    public function mount()
    {
        $this->allLeaders = User::where('tenant_id', Auth::user()->tenant_id)
                                ->orderBy('first_name')
                                ->get(['id', 'first_name', 'last_name']);
    }

    public function updating($key)
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    // --- Sorting Methods ---
    public function setSortBy($newSortBy)
    {
        if ($this->sortBy === $newSortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $newSortBy;
            $this->sortDirection = 'asc';
        }
    }

    // --- DELETE ACTION ---
    public function deleteDepartment($departmentId)
    {
        $department = Department::where('tenant_id', Auth::user()->tenant_id)
                                 ->findOrFail($departmentId);
                                 
        $departmentName = $department->name;
        $memberCount = $department->members()->count();

        $department->delete();
        
        session()->flash('message', [
            'type' => 'success',
            'title' => 'Department Deleted',
            'message' => "Department '{$departmentName}' has been permanently deleted." . 
                         ($memberCount > 0 ? " {$memberCount} member assignments were removed." : '')
        ]);
        
        $this->resetPage();
    }

    // --- EDIT MODAL METHODS ---
  public function showEditModal($departmentId)
{
    \Log::info('=== showEditModal METHOD CALLED ===');
    \Log::info('Department ID: ' . $departmentId);
    \Log::info('Current user tenant ID: ' . Auth::user()->tenant_id);
    
    try {
        $department = Department::where('tenant_id', Auth::user()->tenant_id)
                                 ->findOrFail($departmentId);
        
        \Log::info('Department found: ' . $department->name);
        
        $this->departmentId = $department->id;
        $this->departmentName = $department->name;
        $this->departmentStatus = $department->status;
        $this->departmentLeaderId = $department->leader_id;
        
        $this->showEditModal = true;
        
        \Log::info('Modal state set to: true');
        \Log::info('Data loaded:', [
            'name' => $this->departmentName,
            'status' => $this->departmentStatus,
            'leader_id' => $this->departmentLeaderId
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in showEditModal: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
    }
}

    public function updateDepartment()
    {
        $validatedData = $this->validate([
            'departmentName' => 'required|string|max:255',
            'departmentStatus' => ['required', Rule::in(['Active', 'Inactive'])],
            'departmentLeaderId' => 'nullable|exists:users,id',
        ]);

        $department = Department::where('tenant_id', Auth::user()->tenant_id)
                                 ->findOrFail($this->departmentId);

        $department->update([
            'name' => $validatedData['departmentName'],
            'status' => $validatedData['departmentStatus'],
            'leader_id' => $validatedData['departmentLeaderId'] ?? null,
        ]);

        // Close the modal
        $this->showEditModal = false;
        
        // Reset form properties (optional but good practice)
        $this->reset(['departmentId', 'departmentName', 'departmentStatus', 'departmentLeaderId']);
        
        session()->flash('message', [
            'type' => 'success',
            'title' => 'Update Success',
            'message' => "Department '{$department->name}' has been successfully updated.",
        ]);
    }

    // --- Render Method ---
    public function render()
    {
        $tenantId = Auth::user()->tenant_id;
        
        $departments = Department::with('leader')
            ->where('tenant_id', $tenantId)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('leader', function ($subQuery) {
                          $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                                   ->orWhere('last_name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'All', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.church-admin-dashboard.department-index', [
            'departments' => $departments,
        ]);
    }
}