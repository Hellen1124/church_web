<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole; 
use App\Traits\BelongsToTenant;
use App\Traits\TracksUserActions;

class Role extends SpatieRole
{
    // Essential Traits
    use HasFactory, SoftDeletes;
    
    // Custom Traits
    use BelongsToTenant, TracksUserActions;

    // Use Spatie's internal properties for permissions loading
    protected $with = ['permissions']; 

    // Define all custom and inherited fillable fields
    protected $fillable = [
        'user_id',          // For the creator/tracker
        'tenant_id',        // For the BelongsToTenant trait
        'title',            // Your custom field
        'description',      // Your custom field
        'name',             // Spatie field
        'guard_name',       // Spatie field
    ];

    /**
     * Relationship to the User who created this role (using user_id FK).
     * This method name is safe and does not conflict with Spatie.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The permissions relationship (overridden to ensure custom table name if needed).
     * This is required because Spatie's base model uses different foreign keys/tables.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permissions', // Ensure this matches your config/database
            'role_id',
            'permission_id'
        );
    }

    
}
