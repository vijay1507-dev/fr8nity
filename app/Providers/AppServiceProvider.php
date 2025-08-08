<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        // Set default timezone
        Config::set('app.timezone', 'UTC');

        // Share site settings with all views
        try {
            $siteSettings = [
                'site_phone' => Setting::get('site_phone', ''),
                'site_email' => Setting::get('site_email', ''),
                'social_facebook' => Setting::get('social_facebook', ''),
                'social_instagram' => Setting::get('social_instagram', ''),
                'social_linkedin' => Setting::get('social_linkedin', ''),
                'social_twitter' => Setting::get('social_twitter', ''),
                'social_youtube' => Setting::get('social_youtube', ''),
            ];
            View::share('siteSettings', $siteSettings);
        } catch (\Throwable $e) {
            // During fresh install or before migrations, the settings table may not exist
        }
    }
}
