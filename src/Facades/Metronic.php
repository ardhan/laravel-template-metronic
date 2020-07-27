<?php
namespace Ardhan\LaravelTemplateMetronic\Facades;

use Illuminate\Support\Facades\Facade;

class Metronic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'metronic';
    }
}
