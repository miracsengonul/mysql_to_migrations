<?php

namespace mirac\m2m;

use Illuminate\Support\ServiceProvider;

class M2MServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        return $this->app->bind('m2m',function(){
            return new M2M(config('app.m2m'));
        });
    }
}
