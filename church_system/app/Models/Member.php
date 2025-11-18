<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksUserActions;

class Member extends Model
{
    use HasFactory, SoftDeletes, TracksUserActions;

    protected $fillable = [
        'tenant_id',
        'membership_no',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'date_joined',
        'status',
        'baptism_date',
        'confirmed_at',
        'role',
    ];

    protected $cast = [
        'date_of_birth' => 'date',
        'date_joined'  => 'date',
        'baptism_date' => 'date',
        'confirmed_at' => 'date',
    ];

    // Relationships

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations');
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

     public function user()
    {
        return $this->hasOne(User::class); // Member can have one system account
    }

    // Accessors & Mutators

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
