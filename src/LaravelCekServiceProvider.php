<?php

namespace Reaimagine\LaravelCek;

use Illuminate\Support\ServiceProvider;

class LaravelCekServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-cek.php', 'laravel-cek');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/laravel-cek.php' => config_path('laravel-cek.php')], 'config');
    }
}
