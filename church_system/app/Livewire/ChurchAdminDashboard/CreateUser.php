<?php


namespace App\Livewire\ChurchAdminDashboard;

use App\Models\User;
use App\Models\Member;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use WireUi\Traits\WireUiActions;

class CreateUser extends Component
{
    use WireUiActions;

    // Form properties
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';

    // Role selection - now only for Spatie roles
    public $selectedRole = '';
    public $availableRoles = [];

    protected $assignableRoles = [
        'church-treasurer',
        'church-lead',
    ];

    public function mount()
    {
        if (!auth()->user()->hasRole('church-admin')) {
            abort(403);
        }

        $this->availableRoles = Role::whereIn('name', $this->assignableRoles)
            ->get()
            ->map(fn ($role) => [
                'label' => ucwords(str_replace('-', ' ', $role->name)),
                'value' => $role->name,
            ])
            ->toArray();

        $this->selectedRole = $this->availableRoles[0]['value'] ?? '';
    }

    protected function rules()
    {
        $tenantId = auth()->user()->tenant_id;

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'selectedRole' => ['required', Rule::in($this->assignableRoles)],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(fn ($q) =>
                    $q->where('tenant_id', $tenantId)
                ),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->where(fn ($q) =>
                    $q->where('tenant_id', $tenantId)
                ),
            ],
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function saveUser()
    {
        $this->validate();

        $tenantId = auth()->user()->tenant_id;

        DB::beginTransaction();

        try {
            // 1️⃣ Create Member (NO ROLE COLUMN NEEDED)
            $member = Member::create([
                'tenant_id' => $tenantId,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => 'active',
                'date_joined' => now(),
                // NO 'role' field here - roles are handled by Spatie via User model
            ]);

            // 2️⃣ Create User linked to Member
            $user = User::create([
                'tenant_id' => $tenantId,
                'member_id' => $member->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password,
                'created_by' => auth()->id(),
            ]);

            // 3️⃣ Commit DB transaction
            DB::commit();

            // 4️⃣ Assign Spatie Role (Single Source of Truth for Roles)
            if ($this->selectedRole) {
                $user->assignRole($this->selectedRole);
            } else {
                Log::warning('No role selected for user ID: ' . $user->id);
            }

            // 5️⃣ Handle OTP sending
            $otpService = app(\App\Services\OtpService::class);

            if (app()->environment('local', 'development')) {
                // Dev mode: send OTP immediately and log it
                $otp = $otpService->send($user->phone);

                Log::info('DEV OTP', [
                    'phone' => $user->phone,
                    'otp'   => $otp->code,
                ]);

                $otpMessage = 'OTP generated and logged for development';
            } else {
                // Production: queue OTP asynchronously
                dispatch(function () use ($user, $otpService) {
                    $otpService->send($user->phone);
                })->afterCommit();

                $otpMessage = 'OTP has been sent to the user';
            }

            // 6️⃣ Success Notification
            $this->notification()->send([
                'icon' => 'success',
                'title' => 'Success',
                'description' => "{$member->full_name} created successfully with role: " . 
                               ucwords(str_replace('-', ' ', $this->selectedRole)) . ". {$otpMessage}",
            ]);

            // 7️⃣ Reset form fields
            $this->reset([
                'first_name',
                'last_name',
                'email',
                'phone',
                'password',
                'password_confirmation',
            ]);

            $this->selectedRole = $this->availableRoles[0]['value'] ?? '';

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('CreateUser + OTP failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Error',
                'description' => 'User creation failed. ' . $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.church-admin-dashboard.create-user');
    }
}

