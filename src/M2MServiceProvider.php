<?php

namespace mirac\m2m;

use mirac\m2m;
use Illuminate\Support\ServiceProvider;

class M2MServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(M2M::class, function ($app) {
            return new M2M($app['config']['m2m']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [M2M::class];
    }

}
