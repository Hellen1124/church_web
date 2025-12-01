<?php

namespace App\Livewire\SuperAdminNav;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordForm extends Component
{
    /**
     * The component's state.
     */
    public array $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * Status message after an action.
     */
    public ?string $status = null;
    
    /**
     * Update the user's password.
     */
    public function updatePassword(): void
    {
        $this->resetErrorBag();

        $validatedData = $this->validate([
            'state.current_password' => ['required', 'string'],
            'state.password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            // Customize attribute names for better error messages
            'state.current_password' => 'current password',
            'state.password' => 'new password',
            'state.password_confirmation' => 'confirm password',
        ]);
        
        // 1. Verify Current Password
        if (! Hash::check($validatedData['state']['current_password'], Auth::user()->password)) {
            // Throw a validation error specifically for the current password field
            throw ValidationException::withMessages([
                'state.current_password' => __('This current password does not match our records.'),
            ])->errorBag('updatePassword');
        }

        // 2. Update the Password
        Auth::user()->forceFill([
            'password' => Hash::make($validatedData['state']['password']),
        ])->save();

        // 3. Clear fields and set success status
        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->status = 'Password updated successfully.';
        
        // 4. Dispatch event (optional, can be used to notify other components)
        $this->dispatch('password-updated');
    }

    public function render()
    {
        return view('livewire.super-admin-nav.update-password-form');
    }
}
