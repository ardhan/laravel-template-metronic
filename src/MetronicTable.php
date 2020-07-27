<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Table;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;


class MetronicTable
{
    private $table;
    private $selector = 'kt-datatable';
    private $title;
    private $script;
    private $row = [];
    private $coldef = [];
    private $tools = [];
    private $sweetalert = [];

    /**
     * konstruksi kelas
     * @param string $title
     */
    public function __construct($title)
    {
        $this->table = new Table();
        $this->title = $title;
        return $this;
    }


    /**
     * menambahkan row
     * @param  array $col array of column content
     * @return object
     */
    public function row($col)
    {
        $this->row[] = $col;
        return $this;
    }


    /**
     * standar definisi kolom
     * @param  array $coldef
     * @return object
     */
    public function coldef($coldef)
    {
        $this->coldef[] = $coldef;
        return $this;
    }


    public function column($field, $title = '')
    {
        if($title == '') $title = $field;

        return $this->coldef([
            'field' => $field,
            'title' => $title
        ]);
    }


    public function button($title, $button)
    {
        return $this->coldef([
            'field' => $title,
            'title' => $title,
            'template' => "*function(row){return '".$button."'}*",
        ]);
    }

    public function sweetalert($sweetalert)
    {
        $this->sweetalert[] = $sweetalert;
    }


    public function checkbox($id_name, $type='text', $width="20px")
    {
        return $this->coldef([
            'field' => $id_name,
            'title' => '',
            'sortable' => 'false',
            'width' => $width,
            'type' => $type,
            'selector' => "{class: 'kt-checkbox--solid'}",
            'textAlign' => 'center',
        ]);
    }

    public function getScript(){

        $s = '$(document).ready(function() {';
        $s .= "var dataJSONArray = ".json_encode($this->row).";";

        $data = [
            'type' => 'local',
			'source' => '*dataJSONArray*',
			'pageSize' => '10',
        ];


        $s .= 'var datatable = $(".kt-datatable").KTDatatable({';
        $data = json_encode($data);
        $data = str_replace('"*', '', $data);
        $data = str_replace('*"', '', $data);

        $coldef = json_encode($this->coldef);
        $coldef = str_replace('"*', '', $coldef);
        $coldef = str_replace('*"', '', $coldef);
        $coldef = str_replace('*+', "'+", $coldef);
        $coldef = str_replace('+*', "+'", $coldef);
        $s .= 'data : '.$data.',';
        $s .= 'pagination : true,';
        $s .= 'columns : '.$coldef;
        $s .= '});';
        
        $s .= '});';
        return $s;
    }

    public function getSweetAlert()
    {
        $s = '$(document).ready(function() {';
        if(count($this->sweetalert) > 0){
            foreach($this->sweetalert as $sa){
                $s .= '$(\'.'.$this->selector.' tbody\').on(\'click\', \''.$sa->getSelector().'\', function (e) {';
                $s .= $sa;
                $s .= '});';
            }
        }
        $s .= '});';
        return $s;
    }


    public function addTools($caption = '', $url = '', $color = 'primary')
    {
        $this->tools[] = Metronic::button($caption, $url, $color);
    }

    public function resolveTools()
    {
        $tools = '';
        foreach($this->tools as $t){
            $tools .= $t.'&nbsp;';
        }
        return $tools;
    }



    public function __toString()
    {
        $container = El::div('', 'kt-portlet kt-portlet--mobile');

        $header = El::div('', 'kt-portlet__head kt-portlet__head--lg');
        $body = El::div('', 'kt-portlet__body');
        $body_kit = El::div(El::div('', $this->selector, 'local_data'), 'kt-portlet__body kt-portlet__body--fit');

        //label
        $label = El::div(El::h3($this->title, 'kt-portlet__head-title'), 'kt-portlet__head-label');
        $header->content($label);

        //toolbar
        $toolbar = El::div('', 'kt-portlet__head-toolbar');
        $toolbarWrapper = El::div($this->resolveTools(), 'kt-portlet__head-wrapper');

        $toolbar->content($toolbarWrapper);

        $header->content($toolbar);

        $container->content($header);
        $container->content($body);
        $container->content($body_kit);
        return $container->__toString();
    }

}
