<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class MemberIndex extends Component
{
    use WithPagination;

    // --- State properties for filtering and searching ---
    public $search = '';
    public $statusFilter = '';
    public $roleFilter = '';
    public $perPage = 10;

    // Available filters (These should align with your Member model data)
    public $statuses = ['Active', 'Inactive', 'Pending'];
    public $roles = ['Member', 'Elder', 'Pastor', 'Volunteer']; 

    // --- Deletion State Properties (NEW) ---
    public $memberToDelete = null;
    public $confirmingMemberDeletion = false;

    protected $paginationTheme = 'tailwind';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
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

    // --- DELETION LOGIC ---
    
    /**
     * Set the member ID and open a confirmation modal.
     * @param int $memberId
     */
    public function confirmMemberDeletion($memberId)
    {
        // 1. Permission Check (Security)
        $hasPermission = Auth::user()->can('delete members');
        
        Log::info('Attempting to confirm deletion for Member ID: ' . $memberId);
        Log::info('Member Deletion Permission Check: ' . ($hasPermission ? 'TRUE' : 'FALSE'));

        if (!$hasPermission) {
            Log::error('Unauthorized access attempt: User lacks "delete members" permission.');
            // This line stops execution and throws the 403 error.
            abort(403, 'Unauthorized. User does not have permission to delete members.');
        }

        // 2. Set state to show modal
        // Ensure the member exists and belongs to the current tenant before setting state
        $member = Member::where('tenant_id', Auth::user()->tenant_id)->findOrFail($memberId);
        
        $this->memberToDelete = $member->id;
        $this->confirmingMemberDeletion = true;
    }

    /**
     * Executes the deletion after confirmation.
     */
    public function deleteMember()
    {
        if ($this->memberToDelete) {
            // Re-check permission before executing destructive action
            if (!Auth::user()->can('delete members')) {
                Log::error('Deletion execution blocked: Missing "delete members" permission.');
                session()->flash('error', 'Permission denied for deletion.');
                return;
            }
            
            try {
                // Fetch the member, ensuring it belongs to the current tenant
                $member = Member::where('tenant_id', Auth::user()->tenant_id)->findOrFail($this->memberToDelete);
                
                $member->delete();
                session()->flash('success', 'Member ' . $member->first_name . ' deleted successfully.');

            } catch (\Exception $e) {
                Log::error('Member deletion failed: ' . $e->getMessage());
                session()->flash('error', 'Could not delete member. Error: ' . $e->getMessage());
            }
        }
        
        // Reset state
        $this->memberToDelete = null;
        $this->confirmingMemberDeletion = false;
        $this->resetPage();
    }
    
    // --- UTILITY FUNCTION ---
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'roleFilter']);
        $this->resetPage();
    }
    
    // --- RENDER METHOD ---
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
}
