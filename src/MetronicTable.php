<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Table;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;


class MetronicTable
{
    /**
     * ---------------------------------------------------------------------------------------------
     * PARAMETER
     * ---------------------------------------------------------------------------------------------
     */

    /**
     * variable untuk menyimpan table
     * @var [type]
     */
    private $table;

    /**
     * selector untuk datatable
     * @var string
     */
    private $selector = 'kt-datatable';

    /**
     * judul pada portlet yang menyimpan table
     * @var string
     */
    private $title;

    /**
     * script yang digunakan untuk menyimpan script datatable
     * @var string
     */
    private $script;

    /**
     * baris pada table
     * @var array
     */
    private $row = [];

    /**
     * variable yang menyimpan definisi kolom
     * @var array
     */
    private $coldef = [];

    /**
     * kumpulan tombol pada header portlet yang menyimpan table;
     * @var array
     */
    private $tools = [];

    /**
     * kumpulan sweetalert
     * @var array
     */
    private $sweetalert = [];

    /**
     * button yang ada pada header portlet
     * @var array
     */
    private $button_header = [];

    /**
     * variable yang menyimpan url yang merupakan server data untuk datatable
     * @var string
     */
    private $server_data = "";

    /**
     * kumpulan filter pada table, muncul dalam portlet diatas table
     * @var array
     */
    private $filter = [];





    /**
     * ---------------------------------------------------------------------------------------------
     * METHOD
     * ---------------------------------------------------------------------------------------------
     */

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
     * menentukan server untuk datatable
     * @param  string $server url
     * @return object
     */
    public function server($server)
    {
        $this->server_data = $server;
        return $this;
    }


    /**
     * menambahkan tools
     * @param string $caption judul tombol
     * @param string $url     link
     * @param string $color   warna tombol
     */
    public function addTools($caption = '', $url = '', $color = 'primary')
    {
        $this->tools[] = Metronic::button($caption, $url, $color);
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


    /**
     * Menambahkan kolom pada table
     * @param  string $field key data
     * @param  string $title judul kolom
     * @return object
     */
    public function column($field, $title = '')
    {
        if($title == '') $title = $field;

        return $this->coldef([
            'field' => $field,
            'title' => $title
        ]);
    }


    /**
     * menambahkan kolom yang isinya button
     * @param  string $title  judul kolom
     * @param  string $button kumpulan tombol
     * @return object
     */
    public function button($title, $button)
    {
        return $this->coldef([
            'field' => $title,
            'title' => $title,
            'template' => "*function(row){return '".$button."'}*",
        ]);
    }


    /**
     * Menambahkan kolom untuk checkbox
     * @param  string $id_name key data
     * @param  string $type    jenis key (integer/string)
     * @param  string $width   lebar kolom
     * @return object
     */
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


    /**
     * menambahkan definisi sweetalert
     * @param  object $sweetalert Object Kelas MetronicSweetAlert
     * @return object
     */
    public function sweetalert($sweetalert)
    {
        $this->sweetalert[] = $sweetalert;
        return $this;
    }


    /**
     * ---------------------------------------------------------------------------------------------
     * FORM FILTER
     * ---------------------------------------------------------------------------------------------
     */

    /**
     * menambahkan filter search pada portlet
     * @return string
     */
    function search()
    {
        $container = El::div('', 'col-md-4 kt-margin-b-20-tablet-and-mobile');
        $container_input = El::div('', 'kt-input-icon kt-input-icon--left');
        $input = El::InputText('search', '', 'form-control', 'generalSearch');

        $container_input->content($input);
        $container->content($container_input);

        return $container;
    }


    /**
     * menambahkan filter berjenis select pada portlet
     * @param  array $option  array filter: contoh $option = [1 => "Pending", 2 => "Success"]
     * @param  string $id      id pada komponen select untuk selector javascript
     * @param  string $caption label judul
     * @param  string $size    ukuran kontainer
     * @return object
     */
    function select($option, $id, $caption = '', $size = '4')
    {
        $this->filter[] = [
            "option" => $option,
            "id" => $id,
            "caption" => $caption
        ];
        return $this;
    }


    /**
     * Mendapatkan javascript dari datatable dan sweet alert
     * @return string
     */
    public function getScript(){

        $coldef = json_encode($this->coldef);
        $coldef = str_replace('"*', '', $coldef);
        $coldef = str_replace('*"', '', $coldef);
        $coldef = str_replace('*+', "'+", $coldef);
        $coldef = str_replace('+*', "+'", $coldef);

        $remote = "data : {type: 'remote',";
		$remote .= 'source: {';
		$remote .= 'read: {';
		$remote .= 'url: "'.url($this->server_data).'",';
		$remote .= 'headers: {"X-CSRF-TOKEN" : "'.csrf_token().'"},';

        $remote .= 'map: function(raw) {';
		$remote .= 'var dataSet = raw;';
		$remote .= 'if (typeof raw.data !== "undefined") { dataSet = raw.data; }';
		$remote .= 'console.log(dataSet);';
        $remote .= 'return dataSet;';
        $remote .= '},'; //endmap

        $remote .= '},'; //endread
        $remote .= '},'; //endsource
        $remote .= 'pageSize: 10, serverPaging: true, serverFiltering: true, serverSorting: true,';
        $remote .= '},'; //end data

        $s = 'var datatable = $(".kt-datatable").KTDatatable({';
        $s .= $remote;//($this->url != '') ? $remote : $local;
        $s .= 'layout: {scroll : false, footer : false}, ';
        $s .= 'pagination: true, ';
        $s .= 'search: {input: $("#generalSearch"),},';
        $s .= 'columns: '.$coldef.'';
        $s .= '});';

        foreach($this->filter as $filter){
            $s .= '$("#'.$filter["id"].'").on("change", function() {';
            $s .= 'datatable.search($(this).val().toLowerCase(), "Prioritas");';
            $s .= '});';
            $s .= '$("#'.$filter["id"].'").selectpicker();';
        }


        if(count($this->sweetalert) > 0){
            foreach($this->sweetalert as $sa){
                $s .= 'datatable.on(\'click\', \''.$sa->getSelector().'\', function (e) {';
                $s .= $sa;
                $s .= '});';
            }
        }

        return $s;
    }


    /**
     * resolve tools
     * @return string
     */
    public function resolveTools()
    {
        $tools = '';
        foreach($this->tools as $t){
            $tools .= $t.'&nbsp;';
        }
        return $tools;
    }


    /**
     * resolve filter
     * @return string
     */
    function resolveFilter()
    {
        $filter = '';
        foreach($this->filter as $ft){
            $container = El::div('', 'col-md-4 kt-margin-b-20-tablet-and-mobile');
            $container_form = El::div('', 'kt-form__group kt-form__group--inline');
            //label
            if($ft["caption"] != ''){
                $label = El::div('<label>'.$ft["caption"].'</label>', 'kt-form__label');
                $container_form->content($label);
            }

            //select
            $container_select = El::div('', 'kt-form__control');
            $select = El::select('select')->options($ft["option"])->cls('form-control bootstrap-select')->id($ft["id"]);


            $container_select->content($select);

            $container_form->content($container_select);

            $container->content($container_form);

            $filter .= $container;

        }

        return $filter;
    }

    public function __toString()
    {
        $container = El::div('', 'kt-portlet kt-portlet--mobile');

        $header = El::div('', 'kt-portlet__head kt-portlet__head--lg');
        $body = El::div('', 'kt-portlet__body');
        $body_kit = El::div(El::div('', $this->selector, 'local_data'), 'kt-portlet__body kt-portlet__body--fit');

        //form
        $container_form = El::div('', 'kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10');
        $rowing_form = El::div('', 'row align-items-center');
        $col_form = El::div('', 'col-xl-8 order-2 order-xl-1');
        $centering_content = El::div('', 'row align-items-center');

        $centering_content->content($this->search().$this->resolveFilter());

        $col_form->content($centering_content);
        $rowing_form->content($col_form);
        $container_form->content($rowing_form);
        $body->content($container_form);

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
