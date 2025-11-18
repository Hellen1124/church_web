<?php

namespace App\Livewire\SuperAdminUsers;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class UsersIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $tenantFilter = '';
    public $roleFilter = '';
    public $perPage = 25;

    protected $queryString = ['search', 'tenantFilter', 'roleFilter'];

    public function impersonate($userId)
    {
        if (!auth()->user()->hasRole('super-admin')) abort(403);
        
        session(['impersonated_by' => auth()->id()]);
        auth()->loginUsingId($userId);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Now impersonating user!']);
        return redirect()->route('dashboard');
    }

    public function stopImpersonating()
    {
        if (session('impersonated_by')) {
            auth()->loginUsingId(session('impersonated_by'));
            session()->forget('impersonated_by');
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Back to God Mode']);
        }
        return redirect()->route('super-admin.users.index');
    }

    public function render()
    {
        $users = User::query()
            ->with(['tenant', 'roles'])
            ->when($this->search, fn($q) => $q->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->when($this->tenantFilter, fn($q) => $q->whereHas('tenant', fn($q) => $q->where('id', $this->tenantFilter)))
            ->when($this->roleFilter, fn($q) => $q->whereHas('roles', fn($q) => $q->where('name', $this->roleFilter)))
            ->latest()
            ->paginate($this->perPage);

        $tenants = \App\Models\Tenant::pluck('church_name', 'id');
        $roles = \Spatie\Permission\Models\Role::pluck('name', 'name');

        return view('livewire.super-admin-users.users-index', [
            'users' => $users,
            'tenants' => $tenants,
            'roles' => $roles,
        ]);

    }
}


