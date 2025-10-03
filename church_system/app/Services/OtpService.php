<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public function send(string $phone): Otp
    {
        $dailyCount = Otp::whereDate('created_at', today())
            ->where('phone', $phone)
            ->count();

        if ($dailyCount >= config('otp.daily_send_limit')) {
            throw ValidationException::withMessages([
                'phone' => 'Daily OTP limit reached. Try again tomorrow.',
            ]);
        }

        $recent = Otp::activeForPhone($phone)->latest()->first();
        if ($recent && $recent->created_at->diffInSeconds(now()) < config('otp.resend_cooldown_seconds')) {
            throw ValidationException::withMessages([
                'phone' => 'Please wait before requesting a new OTP.',
            ]);
        }

        $otpLength = config('otp.length');
        $code = str_pad(random_int(0, pow(10, $otpLength) - 1), $otpLength, '0', STR_PAD_LEFT);

        Log::info('Fake OTP generated', [
            'phone' => $phone,
            'otp' => $code,
        ]);

        $otp = Otp::create([
            'phone'      => $phone,
            'code_hash'  => Hash::make($code),
            'secret'     => Str::random(32),
            'provider'   => 'fakesms',
            'expires_at' => now()->addMinutes(config('otp.expires_minutes')),
        ]);

        if (config('otp.use_queue')) {
            dispatch(new \App\Jobs\SendOtpSmsJob($phone, $code));
        } else {
            $this->sendSmsNow($phone, $code);
        }

        return $otp;
    }

    public function verify(string $phone, string $code): bool
    {
        $otp = Otp::activeForPhone($phone)->latest()->first();

        if (! $otp) {
            throw ValidationException::withMessages([
                'code' => 'OTP expired or not found.',
            ]);
        }

        if ($otp->isExpired()) {
            throw ValidationException::withMessages([
                'code' => 'OTP has expired.',
            ]);
        }

        if ($otp->attempts >= config('otp.max_attempts')) {
            throw ValidationException::withMessages([
                'code' => 'Too many attempts. Request a new OTP.',
            ]);
        }

        $otp->incrementAttempts();

        if (! Hash::check($code, $otp->code_hash)) {
            throw ValidationException::withMessages([
                'code' => 'Invalid OTP code.',
            ]);
        }

        $otp->markAsUsed();

        return true;
    }

    public function sendSmsNow(string $phone, string $code): void
    {
        Log::info('FakeSMS sent', [
            'phone' => $phone,
            'status' => 200,
            'body' => ['message' => "Fake SMS sent: Your OTP is {$code}"],
        ]);
    }
}


