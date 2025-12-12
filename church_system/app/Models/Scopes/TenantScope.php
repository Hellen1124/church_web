<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
{
    // Get the table name
    $table = $model->getTable();
    
    // List of tables that should use DIFFERENT tenant filtering logic
    $specialTables = [
        'roles',
        'permissions',
        'model_has_roles',
        'model_has_permissions',
        'role_has_permissions',
    ];
    
    // For role/permission tables: get BOTH null AND current tenant's
    if (in_array($table, $specialTables)) {
        if (session()->has('tenant_id')) {
            $tenantId = session()->get('tenant_id');
            $builder->where(function($query) use ($table, $tenantId) {
                $query->where("$table.tenant_id", $tenantId)
                      ->orWhereNull("$table.tenant_id");
            });
        }
        return;
    }
    
    // For ALL OTHER tables: normal tenant filtering
    if (session()->has('tenant_id')) {
        $builder->where("$table.tenant_id", session()->get('tenant_id'));
    }
}
}
