<?php

namespace Internetcode\LaravelUserSettings;

use Illuminate\Support\ServiceProvider;

class LaravelUserSettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/user-settings.php' => config_path('user-settings.php'),
        ], 'config');

        if (! class_exists('CreatePermissionTables')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/create_permission_tables.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_create_permission_tables.php",
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
