<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicIcon
{
    //flaticon
    public static function fti($icon)
    {
        return El::i('flaticon-'.$icon);
    }

    public static function fti2($icon)
    {
        return El::i('flaticon2-'.$icon);
    }

    public static function fa($icon)
    {
        return El::i('fa fa-'.$icon);
    }

    public static function fab($icon)
    {
        return El::i('fab fa-'.$icon);
    }
}
