<?php


namespace LaravelCryptModel;

use Illuminate\Support\ServiceProvider;

class LaravelCryptoModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-crypt-model.php' => config_path('laravel-crypt-model.php'),
        ]);
    }
}