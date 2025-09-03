<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FakeSmsService
{
    public function sendSms(string $phone, string $message): bool
    {
        // Log instead of sending real SMS
        Log::info("Fake SMS to {$phone}: {$message}");
        return true;
    }
}
