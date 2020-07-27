<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicBreadCrumb
{
    private $content = [];

    public function __construct()
    {

    }


    public function link($text, $url)
    {
        $this->content[] = El::a($text, $url, 'kt-subheader__breadcrumbs-link');
        return $this;
    }


    public function resolve()
    {
        $content = El::div('', 'kt-subheader__breadcrumbs');
        foreach($this->content as $c)
        {
            $content->content(El::span('', 'kt-subheader__breadcrumbs-separator'));
            $content->content($c);
        }
        return $content->__toString();
    }


    public function __toString()
    {
        return $this->resolve();
    }

}
