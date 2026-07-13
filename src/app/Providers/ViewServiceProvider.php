<?php

namespace App\Providers;

use App\Models\PageSection;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Log;
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

            try {
                $settings = WebsiteSetting::first();
                $view->with('websiteSettings', $settings);
            } catch (\Throwable $e) {
                Log::warning('ViewServiceProvider: Gagal memuat websiteSettings', [
                    'error' => $e->getMessage(),
                ]);
            }
        });

        // Share page sections to public views
        View::composer(['buses.*', 'pages.*', 'bookings.*', 'partials.*'], function ($view) {
            if (request()->is('admin*') || request()->is('livewire*') || request()->is('api*')) {
                return;
            }

            // Determine current page based on route name
            $pageMap = [
                'home' => 'home',
                'bus.show' => 'home',
                'about' => 'about',
                'services' => 'services',
                'contact' => 'contact',
                'booking.create' => 'home',
                'booking.store' => 'home',
                'booking.index' => 'home',
                'booking.show' => 'home',
            ];

            $routeName = request()->route() ? request()->route()->getName() : null;
            $currentPage = $pageMap[$routeName] ?? null;

            if ($currentPage) {
                try {
                    $pageSections = PageSection::forPage($currentPage)->get()->keyBy('section_key');
                    $view->with('pageSections', $pageSections);

                    if ($pageSections->isEmpty()) {
                        Log::info('ViewServiceProvider: Tidak ada PageSection untuk halaman', [
                            'page' => $currentPage,
                            'route' => $routeName,
                        ]);
                    }
                } catch (\Throwable $e) {
                    Log::error('ViewServiceProvider: Gagal memuat pageSections', [
                        'page' => $currentPage,
                        'route' => $routeName,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        });
    }
}

