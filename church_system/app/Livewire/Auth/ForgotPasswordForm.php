<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use WireUi\Traits\WireUiActions;

class ForgotPasswordForm extends Component

{

    use WireUiActions;

    public string $email = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link sent to your email.');
        } else {
            session()->flash('error', 'Failed to send password reset link.');
        }
    }

    public function render()
    {
        return view('livewire.auth.request-link-form')
            ->layout('layouts.app');
    }
}
