<?php

namespace App\Models;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Traits\BelongsToTenant;

class Role extends SpatieRole
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToTenant;

    protected $with = ['permissions'];


     protected $fillable = [
        'user_id',
        'tenant_id',
        'title',
        'description',
        'name',
        'guard_name',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo //i have used this to fetch the user who created the role
    {
        return $this->belongsTo(User::class);
    }

    
    public function permissions(): BelongsToMany
{
    return $this->belongsToMany(
        Permission::class,
        'role_has_permissions',
        'role_id',
        'permission_id'
    );
}

}
