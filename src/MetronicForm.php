<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Form;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicForm
{
    private $inputs = [];
    private $buttons = [];
    private $title = '';
    private $action = '';
    private $type = '';

    public function __construct($title, $action, $method)
    {
        $this->title = $title;
        $this->action = $action;
        $this->type = 'label-right';
        return $this;
    }

    public function input($label, $content, $placeholder = '', $help = '')
    {
        $input = El::div('', 'form-group');
        if($this->type == 'label-right') $input->cls('row');

        $label = El::label('', $label);
        if($this->type == 'label-right') $label->cls('col-2 col-form-label');

        $help = ($help != '') ? El::span($help, 'form-text text-muted') : '';

        $input->content($label);

        $contentContainer = El::div($content);
        if($this->type == 'label-right') $contentContainer->cls('col-10');
        $input->content($contentContainer);
        $input->content($help);
        return $input;
    }

    public function inputText($name, $label, $value = '', $placeholder = '', $help = '')
    {
        $input = El::input('text', $name, $value)->cls('form-control');
        if($placeholder != '') $input->attr('placeholder', $placeholder);
        $this->inputs[$name] = $this->input($label, $input, $placeholder, $help);

        return $this;
    }

    public function button($button)
    {
        $this->button[] = $button;
        return $this;
    }


    public function __toString()
    {
        $form = El::tag('form');
        $form->cls('kt-form kt-form--label-right');
        $container = Metronic::portlet($this->title);

        foreach($this->inputs as $name => $input)
        {
            $container->content($input);
        }

        $button = '';
        if(count($this->button) > 0)
        {
            foreach($this->button as $b){
                $button .= $b;
            }
            $container->footer($button);
        }


        $form->content($container);
        return $form->__toString();
    }
}
