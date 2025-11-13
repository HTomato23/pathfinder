<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS and correct URL in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            // Force the root URL to match APP_URL from environment
            if ($appUrl = config('app.url')) {
                URL::forceRootUrl($appUrl);
            }
        }

        // Prevent lazy loading in all environments
        Model::preventLazyLoading();
    }
}
