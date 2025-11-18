<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\BelongsToTenant;
use App\Traits\TracksUserActions;

class Permission extends SpatiePermission
{
    // Essential Traits & Custom Traits
    use HasFactory, SoftDeletes, BelongsToTenant, TracksUserActions;

    // Define all custom and inherited fillable fields
    protected $fillable = [
        'user_id',          // For the creator/tracker
        'tenant_id',        // For the BelongsToTenant trait
        'name',             // Spatie field
        'guard_name',       // Spatie field
        'module',           // Your custom field
    ];

    /**
     * Relationship to the User who created this permission (using user_id FK).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

