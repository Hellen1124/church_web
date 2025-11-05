<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Must be empty or only contain standard Laravel code
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Must be empty or only contain standard Laravel code
    }
}
