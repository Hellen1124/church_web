<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'name',
        'guard_name',
        'module',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


