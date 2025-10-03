<?php
// config/otp.php

return [

    /*
    |--------------------------------------------------------------------------
    | OTP Defaults
    |--------------------------------------------------------------------------
    */
    

    'length' => (int) env('OTP_LENGTH', 6),

    'expires_minutes' => (int) env('OTP_EXPIRES_MINUTES', 5),

    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),

    'resend_cooldown_seconds' => (int) env('OTP_RESEND_COOLDOWN_SECONDS', 60),

    'daily_send_limit' => (int) env('OTP_SENDS_PER_DAY', 10),

    'use_queue' => (bool) env('OTP_USE_QUEUE', true),
];

