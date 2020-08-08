<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicPage extends Page{
    /**
     * variable untuk menyimpan menu samping
     * @var string
     */
    private $sideMenu = '';

    /**
     * variable untuk menyimpan menu atas
     * @var string
     */
    private $topMenu = '';

    /**
     * variable untuk menyimpan toolbar: pojok kanan atas
     * @var string
     */
    private $toolBar = '';

    /**
     * variable untuk menyimpan judul sub header
     * @var string
     */
    private $sub_header_title = '';

    /**
     * variable untuk menyimpan breadcrumb
     * @var [type]
     */
    private $breadcrumb = '';

    /**
     * variable yang menyimpan konten pada row
     * @var array
     */
    private $row = [];

    /**
     * variable yang menyimpan row
     * @var array
     */
    private $main_content = [];


    /**
     * konstruksi kelas
     */
    public function __construct()
    {
        parent::__construct();
        $this->meta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no')
            ->css('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700')
            ->css('/metronic/plugins/global/plugins.bundle.css')
            ->css('/metronic/css/style.bundle.css')
            ->css('/metronic/css/skins/header/base/light.css')
            ->css('/metronic/css/skins/header/menu/light.css')
            ->css('/metronic/css/skins/brand/light.css')
            ->css('/metronic/css/skins/aside/light.css')
            ->js('/metronic/plugins/global/plugins.bundle.js')
            ->js('/metronic/js/scripts.bundle.js')
            ->script($this->options());
    }


    /**
     * string dari kelas
     * @return string
     */
    public function __toString()
    {
        //html body
        $this->body->cls("kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading");

        //header mobil
        $ktHeaderMobile = El::div('', 'kt-header-mobile  kt-header-mobile--fixed', 'kt_header_mobile');

        //memasukkan logo ke header mobile
        $ktHeaderMobile->content(El::a(El::img('/metronic/media/logos/logo-dark.png'), '/'));

        //------------------------------------------------------------------------------------------
        // Toolbar: start
        //------------------------------------------------------------------------------------------
        $toolbar = El::div('', 'kt-header-mobile__toolbar');
        $toolbar->content(
            El::Button(El::span(), 'kt-header-mobile__toggler kt-header-mobile__toggler--left', 'kt_aside_mobile_toggler')
        );
        $toolbar->content(
            El::Button(El::span(), 'kt-header-mobile__toggler', 'kt_header_mobile_toggler')
        );
        $toolbar->content(
            El::Button(El::i('flaticon-more'), 'kt-header-mobile__topbar-toggler', 'kt_header_mobile_topbar_toggler')
        );

        //memasukkan toolbar ke header mobile
        $ktHeaderMobile->content($toolbar);
        //------------------------------------------------------------------------------------------
        // Toolbar: end
        //------------------------------------------------------------------------------------------




        //memasukkan header mobile ke body
        $this->body->content($ktHeaderMobile);

        //koneten utama
        $mainContent = El::div('', 'kt-grid kt-grid--hor kt-grid--root');

        //page
        $page = El::div('', 'kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page');

        //wrapper
        $wrapper = El::div('', 'kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper', 'kt_wrapper');



        //------------------------------------------------------------------------------------------
        // ASIDE : start
        //------------------------------------------------------------------------------------------
        $aside = El::div('', 'kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop', 'kt_aside');

        $brand = El::div('', 'kt-aside__brand kt-grid__item ', 'kt_aside_brand');

        //brand << logo
        $brand->content( El::div( El::a( El::img('/metronic/media/logos/logo-dark.png'), '/', 'brand-logo' ), 'kt-aside__brand-logo' ) );

        //brand << toggler
        $iconBukaTutup = El::span(Metronic::svg('AngleDoubleLeft')) . El::span(Metronic::svg('AngleDoubleRight'));
        $brand->content( El::div( El::button( $iconBukaTutup, 'kt-aside__brand-aside-toggler', 'kt_aside_toggler' ),'kt-aside__brand-tools' ));

        //aside << brand
        $aside->content($brand);

        //aside << menu
        $aside->content($this->sideMenu);

        //page << aside
        $page->content($aside);
        //------------------------------------------------------------------------------------------
        // ASIDE : end
        //------------------------------------------------------------------------------------------




        //------------------------------------------------------------------------------------------
        // HEADER : start
        //------------------------------------------------------------------------------------------
        $header = El::div('', 'kt-header kt-grid__item  kt-header--fixed', 'kt_header');
        $headerWrapper = El::div('', 'kt-header-menu-wrapper', 'kt_header_menu_wrapper');
        $headerMenu = El::div('', 'kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default', 'kt_header_menu');

        $headerMenu->content($this->topMenu);
        $headerWrapper->content($headerMenu);
        $header->content( $headerWrapper );

        $toolbar = El::div($this->toolBar, 'kt-header__topbar');
        $header->content($toolbar);

        $wrapper->content($header);
        //------------------------------------------------------------------------------------------
        // HEADER : end
        //------------------------------------------------------------------------------------------





        //kontainer
        $container = El::div('', 'kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor', 'kt_content');

        //sub header
        $subheader = El::div('', 'kt-subheader  kt-grid__item', 'kt_subheader');

        //container sub header
        $subheaderContainer = El::div('', 'kt-container  kt-container--fluid');

        //main sub header
        $subheaderMain = El::div('', 'kt-subheader__main');

        //main title
        $subheaderMainTitle = El::H3($this->sub_header_title, 'kt-subheader__title');

        //memasukkan $subheaderMainTitle ke $subheaderMain
        $subheaderMain->content($subheaderMainTitle);

        //separator
        $subheaderMain->content(El::span('', 'kt-subheader__separator kt-hidden'));

        //memasukkan breadcrumb ke $subheaderMain
        $subheaderMain->content($this->breadcrumb);

        //memasukkan $subheaderMain ke $subheaderContainer
        $subheaderContainer->content($subheaderMain);

        //pending
        //$subheaderContainer->content(El::div('test', 'kt-subheader__toolbar'));

        //memasukkan $subheaderContainer ke $subheader
        $subheader->content($subheaderContainer);

        //memasukkan $subheader ke $container
        $container->content($subheader);

        //memasukkan konten ke $container
        $container->content($this->getContent());

        //memasukkan $container ke $wrapper
        $wrapper->content($container);

        //memasukkan wrapper ke $page
        $page->content($wrapper);

        //memasukkan $page ke $mainContent
        $mainContent->content($page);

        //memasukkan $mainContent ke $body
        $this->body->content($mainContent);

        //hasil halaman
        return parent::__toString();
    }


    /**
     * menentukan sidemenu
     * @param  Ardhan\LaravelTemplateMetronic\MetronicSideMenu $menu
     * @return object
     */
    public function sideMenu($menu)
    {
        $this->sideMenu = $menu;
        return $this;
    }


    /**
     * menentukan topmenu
     * @param  Ardhan\LaravelTemplateMetronic\MetronicTopMenu $menu
     * @return object
     */
    public function topMenu($menu)
    {
        $this->topMenu = $menu;
        return $this;
    }


    /**
     * menambahkan toolbar
     * @param  Ardhan\LaravelTemplateMetronic\MetronicToolbar $menu
     * @return object
     */
    public function toolBar($menu)
    {
        $this->toolBar = $menu;
        return $this;
    }


    /**
     * menentukan judul subheader
     * @param  string $title sub judul
     * @return object
     */
    public function subHeaderTitle($title)
    {
        $this->sub_header_title = $title;
        return $this;
    }


    /**
     * menentukan breadCrumb
     * @param  Ardhan\LaravelTemplateMetronic\MetronicBreadCrumb $bc
     * @return object
     */
    public function breadCrumb($bc)
    {
        $this->breadcrumb = $bc;
        return $this;
    }


    /**
     * menghitung lebar content
     * @return integer
     */
    public function counter(){
        if(isset($this->row[0])){
            $counter = 0;
            foreach($this->row as $col){
                $counter += $col["width"];
            }
            return $counter;
        }else{
            return 0;
        }
    }


    /**
     * Menambahkan content
     * @param Ardhan\LaravelTemplateMetronic\MetronicPortlet $content
     * @param integer                                        $width   lebar content
     */
    public function addContent($content, $width)
    {
        if(($this->counter() + $width) > 12){
            $this->main_content[] = $this->row;
            $this->row = [];
        }
        $this->row[] = ["content" => $content, "width" => $width];
    }


    /**
     * Menambahkan konten berupa table
     * @param Ardhan\LaravelTemplateMetronic\MetronicTable $content
     * @param integer                                      $width    lebar konten
     */
    public function addContentTable($content, $width)
    {
        $this->script($content->getScript());

        if(($this->counter() + $width) > 12){
            $this->main_content[] = $this->row;
            $this->row = [];
        }
        $this->row[] = ["content" => $content, "width" => $width];
    }


    /**
     * Mendapatkan hasil akhir dari konten
     * @return string
     */
    public function getContent()
    {
        if(isset($this->row[0])){
            $this->main_content[] = $this->row;
            $this->row = [];
        }

        $container = El::div('', 'kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid');
        foreach($this->main_content as $mc){
            $row = El::div('', 'row');

            foreach($mc as $col){
                $content = El::div($col["content"], 'col-lg-'.$col["width"]);
                $row->content($content);
            }

            $container->content($row);
        }

        return $container;
    }


    /**
     * Options
     * @return string
     */
    public function options()
    {
        $state = '"brand": "#5d78ff", "dark": "#282a3c", "light": "#ffffff", "primary": "#5867dd", "success": "#34bfa3", "info": "#36a3f7", "warning": "#ffb822", "danger": "#fd3995"';
        $option = 'var KTAppOptions = {';
        $option .= '"colors": {';
        $option .= '"state": {'.$state.'},';
        $option .= '"base": {';
        $option .= '"label": [ "#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466" ],';
        $option .= '"shape": [ "#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a" ]';
        $option .= '}';
        $option .= '}';
        $option .= '};';
        return $option;
    }
}
