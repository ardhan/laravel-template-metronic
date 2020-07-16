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

        $this->app->bind('metronicpage', function() {
            return new MetronicPage();
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
