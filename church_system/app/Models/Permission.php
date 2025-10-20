<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\BelongToTenant;

class Permission extends SpatiePermission
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'user_id', 'tenant_id', 'name', 'guard_name','module'
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}

