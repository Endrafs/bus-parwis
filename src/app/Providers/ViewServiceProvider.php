<?php

namespace App\Providers;

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share website settings to all views
        View::composer('*', function ($view) {
            // Skip admin/Filament panel, Livewire, and API routes
            if (request()->is('admin*') || request()->is('livewire*') || request()->is('api*')) {
                return;
            }

            $settings = WebsiteSetting::first();
            $view->with('websiteSettings', $settings);
        });
    }
}
