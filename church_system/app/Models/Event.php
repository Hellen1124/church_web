<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'description',
        'location',
        'start_at',
        'end_at',
        'capacity',
        'is_public',
        
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_public'=> 'boolean',
        
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // invited / attendees pivot
    public function members()
    {
        return $this->belongsToMany(Member::class, 'event_member')
                    ->using(EventMember::class)
                    ->withPivot([
                        'invited', 'invited_at', 'notified', 'attended', 'attended_at', 'notes'
                    ])
                    ->withTimestamps();
    }
}
