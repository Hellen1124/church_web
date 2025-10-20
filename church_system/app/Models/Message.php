<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'created_by',      // user id who created the message/job
        'subject',
        'body',
        'channel',         // sms, email, push
        'scheduled_at',
        'sent_at',
        'status',          // pending, sending, sent, failed
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
        'metadata'     => 'array',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);     
}

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients()
    {
        return $this->hasMany(MessageRecipient::class);
    }
}
