<?php

namespace App\Livewire\Auth;

use App\Services\OtpService;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyOtpForm extends Component
{
    use WireUiActions;

    public string $phone;
    public string $code = '';
    public bool $canResend = false;
    public int $resendCountdown = 30;

    protected $rules = [
        'code' => 'required|digits:6',
    ];

    public function mount(string $phone)
    {
        $this->phone = $phone;
        $this->startCountdown();
    }

     public function verify(OtpService $otpService)
    {
        Log::info('Verify method called', [
            'phone' => $this->phone,
            'code' => $this->code,
        ]);

        $this->validate();

        try {
            $verified = $otpService->verify($this->phone, $this->code);

            $user = User::where('phone', $this->phone)->first();
            if ($user) {
                $user->update([
                    'phone_verified_at' => now(),
                ]);

                Auth::login($user);

                $user->forcefill([
                    'last_login_at' => now(),
                ])->save();

                $this->notification()->success(
                    title: 'Verified',
                    description: 'Your phone number has been verified. Welcome to your dashboard!'
                );

                Log::info('Verification successful', ['phone' => $this->phone]);

                return redirect()->route('dashboard');
            } else {
                Log::error('User not found', ['phone' => $this->phone]);
                $this->notification()->error(
                    title: 'Error',
                    description: 'User not found.'
                );
            }
        } catch (\Throwable $e) {
            Log::error('Verification error', [
                'phone' => $this->phone,
                'error' => $e->getMessage(),
            ]);
            $this->notification()->error(
                title: 'Invalid OTP',
                description: $e->getMessage()
            );
        }
    }

   public function resendOtp(OtpService $otpService)
    {
        Log::info('Resend OTP called', ['phone' => $this->phone]);

        try {
            $otpService->send($this->phone);
            $this->notification()->success(
                title: 'OTP Sent',
                description: 'We sent a new OTP to your phone number.'
            );
        } catch (\Throwable $e) {
            Log::error('Resend OTP error', [
                'phone' => $this->phone,
                'error' => $e->getMessage(),
            ]);
            $this->notification()->error(
                title: 'Error',
                description: $e->getMessage()
            );
        }

        $this->canResend = false;
        $this->resendCountdown = 30;
        $this->startCountdown();
    }

    private function startCountdown()
    {
        $this->canResend = false;
        $this->resendCountdown = 30;
        // Dispatch browser event to start countdown
        $this->dispatch('startCountdown');
    }

    public function render()
    {
        return view('livewire.auth.verify-otp-form')
            ->layout('layouts.app');
    }
}


   

