<?php

namespace Solitweb\LaravelDirectAdmin;

use Solitweb\DirectAdmin\DirectAdmin;
use Illuminate\Support\ServiceProvider;

class DirectAdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-directadmin.php', 'laravel-directadmin');

        $this->publishes([
            __DIR__.'/../config/laravel-directadmin.php' => config_path('laravel-directadmin.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(LaravelDirectAdmin::class, function () {
            $api = new DirectAdmin();
            $api->connect(config('laravel-directadmin.domain'), config('laravel-directadmin.port'));
            $api->set_login(config('laravel-directadmin.username'), config('laravel-directadmin.password'));
            return new LaravelDirectAdmin($api);
        });
        $this->app->alias(LaravelDirectAdmin::class, 'laravel-directadmin');
    }
}