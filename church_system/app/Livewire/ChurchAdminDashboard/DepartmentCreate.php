<?php


namespace App\Livewire\ChurchAdminDashboard;

use Livewire\Component;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentCreate extends Component
{
    // --- Form Properties ---
    public $name = '';
    public $description = '';
    // ✅ CRUCIAL: Default to null, matching the optional nature of the DB column
    public $leader_id = null; 
    public $status = 'Active';

    // --- Data for Dropdowns ---
    public $leaders = [];
    public $statuses = ['Active', 'Inactive'];

    /**
     * Define validation rules dynamically, including the unique constraint.
     */
    protected function rules()
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:100',
                // Ensure name is unique only within the current tenant's scope
                Rule::unique('departments')->where(fn ($query) => 
                    $query->where('tenant_id', Auth::user()->tenant_id)
                ),
            ],
            'description' => 'nullable|string|max:1000',
            'leader_id' => 'nullable|exists:users,id', // 'nullable' allows null
            'status' => 'required|in:Active,Inactive',
        ];
    }

    /**
     * Lifecycle hook to initialize data, runs once on component load.
     */
    public function mount()
    {
        // Fetch all users within the current tenant to populate the 'Leader' dropdown
        $this->leaders = User::where('tenant_id', Auth::user()->tenant_id)
                            ->select('id', 'first_name', 'last_name')
                            ->orderBy('first_name')
                            ->get();
    }

    /**
     * Store the new department in the database.
     */
    public function saveDepartment()
    {
        // 1. Validate the input (The 'nullable' rule handles the null leader_id)
        $validatedData = $this->validate();

        // 2. Add the mandatory tenant_id 
        $validatedData['tenant_id'] = Auth::user()->tenant_id;
        
        try {
            // 3. Create the new department record
            Department::create($validatedData);

            // 4. Send success message and redirect
            session()->flash('success', 'Department "' . $this->name . '" created successfully.');
            return redirect()->route('church.departments.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Could not save department. Error: ' . $e->getMessage());
            // Log::error('Department creation failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.department-create');
    }
}
