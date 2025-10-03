<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use carbon\Carbon;

class Otp extends Model
{
   protected $table = 'otps';

   protected $fillable = [
         'phone',
        'code_hash',
        'secret',
        'provider',
        'attempts',
        'expires_at',
        'used_at',
   ];

   protected $casts = [
        'attempts' => 'integer',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    // helper: is this OTP expired?
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // helper: is used?
    public function isUsed(): bool
    {
        return ! is_null($this->used_at);
    }

    // mark as used
    public function markAsUsed(): self
    {
        $this->used_at = now();
        $this->save();

        return $this;
    }

    // increment attempts and return new attempts
    public function incrementAttempts(): int
    {
        $this->attempts = $this->attempts + 1;
        $this->save();

        return $this->attempts;
    }

    // scope: active OTPs for a phone (not used and not expired)
    public function scopeActiveForPhone($query, string $phone)
    {
        return $query->where('phone', $phone)
                     ->whereNull('used_at')
                     ->where('expires_at', '>', now());
    }
}