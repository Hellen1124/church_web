<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Hash;



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
            'tenant_id'  => $this->tenant_id ?? null,
            'member_id'  => $this->member_id ?? null,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'password'   => Hash::make($this->password),
            'created_by' => auth()->id(),
        ]);

          // ✅ Generate the OTP
        $otp = rand(100000, 999999);

        // Store OTP
        $user->update(['otp_token' => $otp]);
        
        // Send OTP using your OtpService
        $otpService->send($user->phone, $otp);

        DB::commit();

        // Notify the user
        $this->notification()->success(
            title: 'Account created',
            description: 'An OTP was sent to your phone. Enter it to continue.'
        );

        // Redirect to OTP verification page
        return redirect()->route('otp.verify', ['phone' => $user->phone]);

    } catch (\Throwable $e) {
        DB::rollBack();

        logger()->error('Registration error: ' . $e->getMessage());

        $this->notification()->error(
            title: 'Registration failed',
            description: 'Something went wrong. Please try again.'
        );
    }
}


    public function render()
    {
        return view('livewire.auth.register-form')
            ->layout('layouts.app');
    }
}