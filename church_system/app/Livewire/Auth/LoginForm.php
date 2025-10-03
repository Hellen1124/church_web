<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\WireUiActions;

class LoginForm extends Component
{
    use WireUiActions;

    public string $phone = '';
    public string $password = '';

    protected $rules = [
        'phone'    => 'required|string',
        'password' => 'required|string|min:6',
    ];

    public function login()
{
    $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
        $user = Auth::user();
        if (is_null($user->phone_verified_at)) {
            // Phone not verified, redirect to OTP
            return redirect()->route('otp.verify', ['phone' => $user->phone]);
        }

        // Verified, go to dashboard
        return redirect()->route('dashboard');
    }

    $this->notification()->error('Invalid credentials');
}

    public function render()
    {
        return view('livewire.auth.login-form')
            ->layout('layouts.app');
    }
}
