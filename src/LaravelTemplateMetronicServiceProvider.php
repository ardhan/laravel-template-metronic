<?php

namespace Ardhan\LaravelTemplateMetronic;

use Illuminate\Support\ServiceProvider;

class LaravelTemplateMetronicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('metronic', function() {
            return new Metronic();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
