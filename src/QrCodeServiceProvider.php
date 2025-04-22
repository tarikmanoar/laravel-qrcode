<?php

namespace Manoar\QrCode;

use Illuminate\Support\ServiceProvider;

class QrCodeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/laravel-qrcode.php' => config_path('laravel-qrcode.php'),
        ], 'config');

        // Merge default configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-qrcode.php',
            'laravel-qrcode'
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function ($app) {
            $config = $app['config']->get('laravel-qrcode');
            $generator = new Generator();
            $generator->format($config['format'])
                      ->size($config['size'])
                      ->margin($config['margin'])
                      ->errorCorrection($config['error_correction'])
                      ->encoding($config['encoding']);
            return $generator;
        });
        $this->app->alias(Generator::class, 'qrcode');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Generator::class];
    }
}
