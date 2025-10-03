<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\WireUiActions;


class RegisterForm extends Component
{
    use WireUiActions;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;


    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name'  => 'nullable|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'phone'      => 'required|string|max:20|unique:users,phone',
        'password'   => 'required|string|min:8|confirmed',
       
    ];

   public function register(OtpService $otpService)
{
    $this->validate();
    DB::beginTransaction();
    try {
        $user = User::create([
            'tenant_id'  => 2,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'password'   => bcrypt($this->password),
        ]);
        DB::commit();
        $otpService->send($user->phone);
        $this->notification()->success(
            title: 'Account created',
            description: 'An OTP was sent to your phone. Enter it to continue.'
        );
        return redirect()->route('otp.verify', ['phone' => $user->phone]);
    } catch (\Throwable $e) {
        DB::rollBack();
        logger()->error('Registration error: ' . $e->getMessage());
        $this->notification()->error(
            title: 'Registration failed',
            description: $e->getMessage()
        );
    }
}


    public function render()
    {
        return view('livewire.auth.register-form')
            ->layout('layouts.app');
    }
}