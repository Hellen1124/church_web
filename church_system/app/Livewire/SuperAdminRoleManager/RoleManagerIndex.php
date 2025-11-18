<?php

namespace App\Livewire\SuperAdminRoleManager;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleManagerIndex extends Component
{
    // --- Public Properties (State) ---
    public array $roleData = [];
    public array $roleIds = [];
    public array $permissionGroups = [];

    // Form state
    public bool $showRoleModal = false;
    public $roleId = null;
    public string $name = '';
    public string $description = '';
    public array $selectedPermissions = [];

    // --- Lifecycle ---

    public function mount()
    {
        $this->loadRolesAndPermissions();
    }

    // --- Data Loading ---

    protected function loadRolesAndPermissions(): void
    {
        // 💡 FIX: Fetch ALL roles, including 'super-admin', to display its stats.
        $roles = Role::withCount(['users', 'permissions'])
            ->get();

        $this->roleData = $roles->map(fn($r) => [
            'id' => $r->id,
            'name' => $r->name,
            'description' => $r->description ?? '',
            'users_count' => $r->users_count,
            'permissions_count' => $r->permissions_count,
        ])->toArray();

        $this->roleIds = $roles->pluck('id')->toArray();

        $this->permissionGroups = Permission::all()
            ->groupBy(fn($p) => explode('-', $p->name)[0] ?? 'general')
            ->map->map(fn($p) => ['id' => $p->id, 'name' => $p->name])
            ->toArray();
    }

    // --- Actions ---

    public function createRole(): void
    {
        $this->resetForm();
        $this->showRoleModal = true;
    }

    public function editRole(int $id): void
    {
        $role = Role::with('permissions')->findOrFail($id);

        // Guard against editing the super-admin role
        if ($role->name === 'super-admin') {
            session()->flash('error', 'The Super Admin role cannot be edited.');
            return;
        }

        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->description = $role->description ?? '';
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();

        $this->showRoleModal = true;
    }

    public function saveRole(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|unique:roles,name,' . ($this->roleId ?? 'NULL'),
            'description' => 'nullable|string|max:255',
        ]);
        
        // Prevent editing the name of an existing critical role
        if ($this->roleId && Role::find($this->roleId)->name === 'super-admin') {
             session()->flash('error', 'Cannot modify the Super Admin role name.');
             $this->showRoleModal = false;
             return;
        }

        DB::transaction(function () {
            $role = $this->roleId
                ? Role::findOrFail($this->roleId)
                : Role::create([
                    'name' => $this->name,
                    'guard_name' => 'web',
                    'description' => $this->description,
                ]);

            if (!$this->roleId) {
                $this->roleId = $role->id;
            }

            $role->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            $role->syncPermissions($this->selectedPermissions);
        });

        session()->flash('success', 'Role ' . ($this->roleId ? 'updated' : 'created') . ' successfully.');
        $this->showRoleModal = false;
        $this->loadRolesAndPermissions();
    }

    public function deleteRole(int $id): void
    {
        $role = Role::withCount('users')->findOrFail($id);

        if ($role->name === 'super-admin') { // Explicitly guard deletion
             session()->flash('error', 'The Super Admin role cannot be deleted.');
             return;
        }

        if ($role->users_count > 0) {
            session()->flash('error', 'Cannot delete role with assigned users. Please reassign them first.');
            return;
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
        $this->loadRolesAndPermissions();
    }

    protected function resetForm(): void
    {
        $this->roleId = null;
        $this->name = '';
        $this->description = '';
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.super-admin-role-manager.role-manager');
    }
}