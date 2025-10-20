<?php
namespace App\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Tenant;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
trait BelongsToTenant
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */

    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            // dd(session()->get('tenant_id'), auth()->id());
            if (session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
                if(in_array('user_id', $model->fillable)) {
                    $model->user_id = auth()->id();
                }
            }
        });

    }

    /**
     * Get the tenant that owns the BelongsToTenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeForCurrentTenant($query)
    {
        if (session()->has('tenant_id')) {
            return $query->where('tenant_id', session()->get('tenant_id'));
        }
        return $query;
    }

    public function scopeWithPermissions($query)
    {
        return $query->with('permissions');
    }
}