<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

use App\Models\Event; // Assuming your model is here
// Make sure to remove any use statements for EventPolicy if it doesn't exist

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Ensure this array is either empty or does NOT map Event to a missing Policy.
        // For example: Event::class => EventPolicy::class, // REMOVE THIS LINE IF EventPolicy IS MISSING
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // -----------------------------------------------------------------------
        // MANDATORY: Register a global Gate that delegates all simple string
        // checks (e.g., @can('update events')) directly to Spatie's permission checker.
        // -----------------------------------------------------------------------
        Gate::before(function ($user, $ability) {
            // Check if the User model has the Spatie method (it does, since you use the HasRoles trait)
            if (method_exists($user, 'hasPermissionTo')) {
                // If the user has the permission, return true (grant access).
                // If they don't, return null to continue checking other Gates/Policies.
                return $user->hasPermissionTo($ability) ?: null;
            }
            return null; // Continue with default Laravel authorization
        });
        
    }
}
