<?php
namespace Ardhan\LaravelTemplateMetronic\Facades;


use Illuminate\Support\Facades\Facade;

class MetronicPage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'metronicpage';
    }
}
