<?php

namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use App\Models\Member;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class MemberEdit extends Component
{
    use WithFileUploads; 

    // REQUIRED MODEL PROPERTY
    public ?Member $member = null;

    // FORM PROPERTIES (Matching MemberCreate)
    public $first_name = '';
    public $last_name = '';
    public $gender = '';
    public $date_of_birth = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $date_joined = '';
    public $status = '';
    public $baptism_date = '';
    public $confirmed_at = '';
    public $role = '';
    public $department_id = null;
    
    // Optional property for file uploads
    public $profile_photo; 

    // Dropdown options
    public $statuses = ['Active', 'Inactive', 'Pending'];
    public $roles = ['Member', 'Deacon', 'Pastor', 'Volunteer', 'Elder'];
    public $genders = ['Male', 'Female'];
    public $departments = [];

    // Define validation rules
    protected function rules()
    {
        if (!$this->member) {
            return [];
        }

        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date|before:today',
            'phone' => 'required|string|max:20',
            // Unique rule ignores the current member's email
            'email' => 'nullable|email|unique:members,email,' . $this->member->id, 
            'address' => 'nullable|string|max:255',
            'date_joined' => 'required|date|before_or_equal:today',
            'status' => 'required|in:Active,Inactive,Pending',
            'baptism_date' => 'nullable|date',
            'confirmed_at' => 'nullable|date',
            'role' => 'required|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }
    
    /**
     * Executes on every request for security/tenancy checks.
     */
    public function boot()
    {
        $currentUser = Auth::user();
        
        // 1. Permission Check
        if (!$currentUser->can('update members')) {
            abort(403, 'You do not have permission to update member records.');
        }

        // 2. Tenancy Check (Only executed if member model is loaded)
        if ($this->member) {
            $memberTenantId = (int) $this->member->tenant_id;
            $userTenantId = (int) $currentUser->tenant_id;
            
            if ($memberTenantId !== $userTenantId) {
                abort(403, 'Unauthorized access to this member record.'); 
            }
        }
    }
    
    /**
     * Load existing member data into the component properties (runs only once).
     */
    public function mount(Member $member)
    {
        $this->member = $member;
        $currentUser = Auth::user();
        
        // --- EXPLICIT DATA POPULATION FOR RELIABILITY ---
        $this->first_name = $member->first_name;
        $this->last_name = $member->last_name;
        $this->gender = $member->gender;
        $this->phone = $member->phone;
        $this->email = $member->email;
        $this->address = $member->address;
        $this->status = $member->status;
        $this->role = $member->role;
        // This is key: if department_id is null in DB, it will be null here, which is fine for the <select>
        $this->department_id = $member->department_id; 
        
        // Handle dates: Crucial for HTML date inputs (YYYY-MM-DD format)
        $this->date_of_birth = optional($member->date_of_birth)->toDateString();
        $this->date_joined = optional($member->date_joined)->toDateString();
        $this->baptism_date = optional($member->baptism_date)->toDateString();
        $this->confirmed_at = optional($member->confirmed_at)->toDateString();

        // Fetch all ACTIVE departments for the current tenant
        $this->departments = Department::where('tenant_id', $currentUser->tenant_id)
                                       ->where('status', 'Active')
                                       ->orderBy('name')
                                       ->get(['id', 'name']);
    }

    /**
     * Update the existing member record in the database.
     */
    public function updateMember()
    {
        if (!$this->member) {
            session()->flash('error', 'Member record not found or failed to initialize.');
            return;
        }

        $validatedData = $this->validate();

        try {
            $this->member->update($validatedData);

            session()->flash('success', 'Member record for ' . $this->first_name . ' ' . $this->last_name . ' updated successfully!');

            return redirect()->route('church.members.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Could not update member. Error: ' . $e->getMessage());
            Log::error('Member update failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.member-edit');
    }
}