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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings globally
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $settings = [
                    'app_name' => \App\Models\Setting::get('app_name', 'Buku Tamu Perpustakaan'),
                    'app_logo' => \App\Models\Setting::get('app_logo'),
                ];
                $view->with('global_settings', $settings);
            } catch (\Exception $e) {
                // Database or table might not exist yet during initial setup/migration
            }
        });
    }
}
