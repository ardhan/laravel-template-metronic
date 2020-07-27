<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicPortlet
{
    private $content = '';
    private $title = '';
    private $footer = '';

    public function __construct($title, $content = '', $footer = '')
    {
        $this->content = $content;
        $this->title = $title;
        $this->footer = $footer;
    }

    public function content($content)
    {
        $this->content .= $content;
        return $this;
    }

    public function footer($footer)
    {
        $this->footer = $footer;
        return $this;
    }


    public function __toString()
    {
        $container = El::div('', 'kt-portlet kt-portlet--mobile');


        $head = El::div('', 'kt-portlet__head');
        $label = El::div('', 'kt-portlet__head-label');
        $title = El::h3($this->title, 'kt-portlet__head-title');

        $label->content($title);
        $head->content($label);
        $container->content($head);

        $body = El::div($this->content, 'kt-portlet__body');
        $container->content($body);

        if($this->footer != ''){
            $footer = El::div($this->footer, 'kt-portlet__foot');
            $container->content($footer);
        }


        return $container->__toString();
    }
}
