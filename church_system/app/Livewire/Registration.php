<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;
use App\Services\FakeSmsService;

class Registration extends Component
{
    

    public $first_name;
    public $last_name;
    public $phone;

    public function sendOtp(FakeSmsService $smsService)
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|unique:users,phone',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Create user with OTP as password
        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'otp' => $otp,
        ]);

        // Send OTP via Fake SMS
        $smsService->sendSms($this->phone, "Your OTP is: {$otp}");

        $this->notification()->success(
            'OTP Sent',
            'Check storage/logs/laravel.log for the OTP in development.'
        );

        // Optionally, redirect to login
        return redirect()->route('login.form');
    }

   public function render()
{
    return view('livewire.registration')
        ->layout('layouts.registration'); // 👈 use your actual layout file
}

}
