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
    private $method = '';
    private $type = '';
    private $name = '';


    /**
     * Konstuksi kelas
     * @param string $name   nama form, digunakan untuk selector script
     * @param string $title  judul pada portlet
     * @param string $action tujuan dari form
     * @param string $method method form POST/GET
     */
    public function __construct($name, $title, $action, $method = 'POST')
    {
        $this->name = $name;
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
        $this->type = 'label-right';
        return $this;
    }


    /**
     * base input
     * @param  string $label       caption input
     * @param  string $value       nilai input
     * @param  string $placeholder placeholder pada input
     * @param  string $help        bantuan jika ada
     * @return object
     */
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


    /**
     * menambahkan input text pada form
     * @param  string $name        nama input
     * @param  string $label       caption input
     * @param  string $value       nilai input
     * @param  string $placeholder placeholder pada input
     * @param  string $help        bantuan jika ada
     * @return object
     */
    public function inputText($name, $label, $value = '', $placeholder = '', $help = '')
    {
        $input = El::input('text', $name, $value)->cls('form-control');
        if($placeholder != '') $input->attr('placeholder', $placeholder);
        $this->inputs[$name] = $this->input($label, $input, $placeholder, $help);

        return $this;
    }


    /**
     * menambhakn input select pada form
     * @param  string $name        nama input
     * @param  string $label       caption input
     * @param  array  $preValue    array nilai yang akan dipilih
     * @param  string $value       nilai
     * @param  string $placeholder placeholder
     * @param  string $help        text untuk bantuan jika ada
     * @return object
     */
    public function inputSelect($name, $label, $preValue, $value = '', $placeholder = '', $help = '')
    {
        $input = El::select($name);
        foreach($preValue as $key => $value){
            $input->option($key, $value);
        }
        $input->cls('form-control');
        $this->inputs[$name] = $this->input($label, ' '.$input, $placeholder, $help);

        return $this;
    }


    /**
     * menambahkan tombol pada form / pada footer form
     * @param  array $button tombol pada form, contoh: simpan, kembali
     * @return object
     */
    public function button($button)
    {
        $this->button[] = $button;
        return $this;
    }


    /**
     * javascript untuk memproses form
     * javascript ini akan diambil oleh page
     * @return string javascript
     */
    public function getScript()
    {
        $j  = '$("form[name=\''.$this->name.'\']").submit(function(e){';
        $j .= 'e.preventDefault();';
        $j .= 'var aaData = $( this ).serializeArray();';
        $j .= 'console.log(aaData);';
        $j .= '$.post("'.$this->action.'", aaData).done(function(data){';
        $j .= 'console.log(data);var response = $.parseJSON(data); ';
        $j .= 'swal.fire({';
        $j .= 'position: \'top-right\',';
        $j .= 'type: response.color,';
        $j .= 'title: response.title,';
        $j .= 'text: response.text,';
        $j .= 'showConfirmButton: false,';
        $j .= 'timer: 15000';
        $j .= '});';
        $j .= 'window.location.href = response.redirect;';
        $j .= '})';
        $j .= '});';
        return $j;
    }


    /**
     * Hasil
     * @return string [description]
     */
    public function __toString()
    {
        //membuat form
        $form = El::tag('form');
        $form->attr('name', $this->name);
        $form->cls('kt-form kt-form--label-right');
        $form->attr('action', $this->action);
        $form->attr('method', $this->method);

        //membuat portlet untuk container form
        $container = Metronic::portlet($this->title);

        //memasukkan csrf token pada form
        $form->content(El::inputhidden('_token', csrf_token()));

        //memasukkan seluruh input kedalam form
        foreach($this->inputs as $name => $input){
            $container->content($input);
        }

        //memasukkan button ke dalam footer portlet
        $button = '';
        if(count($this->button) > 0){
            foreach($this->button as $b){
                $button .= $b.' ';
            }
            $container->footer($button);
        }

        $form->content($container);
        return $form->__toString();
    }
}
