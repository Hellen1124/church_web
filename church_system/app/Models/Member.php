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
       
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_joined'  => 'date',
        'baptism_date' => 'date',
        'confirmed_at' => 'date',
    ];

    // Boot method to handle automatic membership number generation
    protected static function booted()
    {
        // Hook into the 'creating' event
        static::creating(function (Member $member) {
            
            // **CRITICAL ASSUMPTION:** $member->tenant_id is already set by the Livewire component.
            
            // 1. Only generate if the membership_no field is empty (user didn't provide one)
            if (empty($member->membership_no)) {
                
                $tenantId = $member->tenant_id;

                // 2. Find the last member record for the current tenant
                $lastMember = static::where('tenant_id', $tenantId)
                    ->orderByDesc('id') 
                    ->first();

                // 3. Calculate the next sequential number
                if ($lastMember && $lastMember->membership_no) {
                    // Extract the sequential part (M) from the last membership_no (T-M)
                    $parts = explode('-', $lastMember->membership_no);
                    
                    // Get the last element, cast it to int, and increment
                    // The (int) cast is crucial for adding 1 correctly
                    $lastSequentialNumber = (int)end($parts);
                    $nextSequentialNumber = $lastSequentialNumber + 1;
                } else {
                    // Start the sequence at 1 if no members exist for this tenant
                    $nextSequentialNumber = 1;
                }

                // 4. Format and Assign the new number (Example: 1 -> 001)
                $paddedNumber = str_pad($nextSequentialNumber, 3, '0', STR_PAD_LEFT);
                
                // 5. Construct the final standardized number (e.g., 1-001)
                $member->membership_no = $tenantId . '-' . $paddedNumber;
            }
        });
    }

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
    
    
    public function hasRole($role)
    {
        return $this->user->hasRole($role);
    }
    // Accessors & Mutators

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
