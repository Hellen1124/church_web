<?php

namespace App\Livewire\ChurchAdminDashboard;


use Livewire\Component;
use App\Models\Member;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MemberCreate extends Component
{
    // Form properties, matching the fillable fields
  
    public $first_name = '';
    public $last_name = '';
    public $gender = 'Male'; // Default
    public $date_of_birth = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $date_joined = '';
    public $status = 'Active'; // Default
    public $baptism_date = '';
    public $confirmed_at = '';
    public $role = 'Member'; // Default
    public $department_id = null;

    // Statuses and roles for dropdowns
    public $statuses = ['Active', 'Inactive', 'Pending'];
    public $roles = ['Member', 'Deacon', 'Pastor', 'Volunteer', 'Elder'];
    public $genders = ['Male', 'Female'];
    public $departments = [];

    public function mount()
    {
        // Fetch all ACTIVE departments for the current tenant to populate the dropdown
        $this->departments = Department::where('tenant_id', Auth::user()->tenant_id)
                                    ->where('status', 'Active')
                                    ->orderBy('name')
                                    ->get(['id', 'name']);
        
        // Set date_joined to today by default for a better UX
        $this->date_joined = Carbon::today()->toDateString();
    }

    // Define validation rules
    protected $rules = [
        
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'gender' => 'required|in:Male,Female',
        'date_of_birth' => 'nullable|date|before:today',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|unique:members',
        'address' => 'nullable|string|max:255',
        'date_joined' => 'required|date|before_or_equal:today',
        'status' => 'required|in:Active,Inactive,Pending',
        'baptism_date' => 'nullable|date',
        'confirmed_at' => 'nullable|date',
        'role' => 'required|string|max:50',
        'department_id' => 'nullable|exists:departments,id',
    ];

    /**
     * Store the new member in the database.
     */
    public function saveMember()
    {
        // 1. Validate the input
        $validatedData = $this->validate();

        // 2. Add the mandatory tenant_id
        $validatedData['tenant_id'] = Auth::user()->tenant_id;

        try {
            // 3. Create the new member record
            Member::create($validatedData);

            // 4. Send success message
            session()->flash('success', 'New member ' . $this->first_name . ' ' . $this->last_name . ' added successfully!');

            // 5. Redirect to the index page
            return redirect()->route('church.members.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Could not save member. Error: ' . $e->getMessage());
            // Log the detailed error
            Log::error('Member creation failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.member-create');
    }
}
