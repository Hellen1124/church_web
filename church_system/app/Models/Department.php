<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksUserActions; 

class Department extends Model
{
    use HasFactory, SoftDeletes, TracksUserActions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'leader_id', // Foreign key pointing to users.id
        'status',
    ];

    // --- Relationships ---

    /**
     * Get the Tenant (Church) that owns the Department.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the User who leads the department.
     * The 'leader_id' points to the 'id' column in the 'users' table.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Get the Members belonging to this Department.
     * (Requires 'department_id' column on the 'members' table).
     */
    public function members()
    {
        return $this->hasMany(Member::class); 
    }

    /**
     * Get the User who created the record (from TracksUserActions trait).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
