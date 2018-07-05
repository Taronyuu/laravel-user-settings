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
            __DIR__ . '/../config/user-settings.php' => config_path('user-settings.php'),
        ], 'config');

        if (! class_exists('AddSettingsColumnToUsersTable')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__ . '/../database/migrations/default_add_settings_column_to_users_table.php' => $this->app->databasePath() . "/migrations/{$timestamp}_add_settings_column_to_users_table.php",
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
