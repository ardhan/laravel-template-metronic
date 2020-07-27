<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicButton
{
    private $caption = '';
    private $url = '';
    private $color = '';
    private $cls = [];
    private $icon_only = false;

    public function __construct($caption, $url = '', $color = '')
    {
        $this->caption = $caption;
        $this->url = $url;
        $this->color = ($color == '') ? 'primary' : $color;
        return $this;
    }

    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    public function caption($caption)
    {
        $this->caption = $caption;
        return $this;
    }

    public function cls($cls)
    {
        $this->cls[] = $cls;
        return $this;
    }

    public function sm()
    {
        $this->cls[] = 'btn-sm';
        return $this;
    }

    public function iconOnly()
    {
        $this->icon_only = true;
        $this->cls[] = 'btn-icon btn-outline-'.$this->color;
        return $this;
    }

    public function lg()
    {
        $this->cls[] = 'btn-lg';
        return $this;
    }

    public function setAsSubmit()
    {

    }


    public function __toString()
    {
        if($this->url == ''){
            $button = El::button($this->caption)->cls('btn');
        }else{
            $button = El::a($this->caption, $this->url)->cls('btn');
        }

        if($this->icon_only == false){
            $button->cls('btn-'.$this->color);
        }

        //resolve class
        if(count($this->cls) > 0){
            foreach($this->cls as $c){
                $button->cls($c);
            }
        }


        return $button->__toString();
    }

}
