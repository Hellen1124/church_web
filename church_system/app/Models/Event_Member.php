<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_Member extends Model
{
    protected $table = 'event_member';

    // If you add an 'id' primary key to pivot table, set incrementing true
    public $incrementing = true;

    protected $fillable = [
        'event_id',
        'member_id',
        'invited',
        'invited_at',
        'notified',
        'attended',
        'attended_at',
        'notes',
    ];

    protected $casts = [
        'invited'    => 'boolean',
        'invited_at' => 'datetime',
        'notified'   => 'boolean',
        'attended'   => 'boolean',
        'attended_at'=> 'datetime',
    ];
}
