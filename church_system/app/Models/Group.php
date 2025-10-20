<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'tenant_id',
        'name',
        'description',
        'leader member_id',
        'metadata',
    ];
    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);     

    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member')
                    ->using(GroupMember::class)
                    ->withPivot(['role', 'joined_at'])
                    ->withTimestamps();
    }

}