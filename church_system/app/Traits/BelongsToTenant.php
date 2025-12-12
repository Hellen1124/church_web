<?php



namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            // Get tenant_id from multiple sources
            $tenantId = null;
            
            // 1. First try from session
            if (session()->has('tenant_id')) {
                $tenantId = session()->get('tenant_id');
            }
            
            // 2. If no session, try from authenticated user
            if (!$tenantId && auth()->check()) {
                $tenantId = auth()->user()->tenant_id;
            }
            
            // 3. If still no tenant_id, use a default for now
            if (!$tenantId) {
                // For development/testing - remove this in production
                $tenantId = 1;
            }
            
            // Set the tenant_id
            $model->tenant_id = $tenantId;
            
            // Auto-set user_id if field exists
            if (in_array('user_id', $model->fillable) && auth()->check() && empty($model->user_id)) {
                $model->user_id = auth()->id();
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
        // Try multiple ways to get current tenant_id
        $tenantId = null;
        
        // 1. From session
        if (session()->has('tenant_id')) {
            $tenantId = session()->get('tenant_id');
        }
        
        // 2. From authenticated user
        if (!$tenantId && auth()->check()) {
            $tenantId = auth()->user()->tenant_id;
        }
        
        if ($tenantId) {
            return $query->where('tenant_id', $tenantId);
        }
        
        // If no tenant_id found, return query as-is (for super admin)
        return $query;
    }
    
    // Removed: scopeWithPermissions - doesn't belong here
    // public function scopeWithPermissions($query)
    // {
    //     return $query->with('permissions');
    // }
}