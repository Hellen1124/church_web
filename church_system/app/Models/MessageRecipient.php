<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRecipient extends Model
{
     protected $fillable = [
        'message_id',
        'member_id',         // optional
        'user_id',           // optional (system user)
        'recipient_contact', // phone or email
        'status',            // pending, sent, failed
        'delivered_at',
        'failure_reason',
        'attempts',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
