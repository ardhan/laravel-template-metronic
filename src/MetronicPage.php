<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicPage extends Page{
    private $sideMenu = '';
    private $topMenu = '';
    private $toolBar = '';
    private $sub_header_title = '';
    private $breadcrumb = '';
    private $row = [];
    private $main_content = [];

    public function __construct()
    {
        parent::__construct();
        $this
        ->meta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no')
        ->css('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700')
        ->css('/metronic/plugins/global/plugins.bundle.css')
        ->css('/metronic/css/style.bundle.css')
        ->css('/metronic/css/skins/header/base/light.css')
        ->css('/metronic/css/skins/header/menu/light.css')
        ->css('/metronic/css/skins/brand/light.css')
        ->css('/metronic/css/skins/aside/light.css')
        ->js('/metronic/plugins/global/plugins.bundle.js')
        ->js('/metronic/js/scripts.bundle.js')
        ->script('
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		');
    }

    public function __toString()
    {
        $this->body->cls("kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading");


        /**
         * Header Mobile
         */
        $ktHeaderMobile = El::div('', 'kt-header-mobile  kt-header-mobile--fixed', 'kt_header_mobile');

        //logo
        $ktHeaderMobile->content(El::a(El::img('/metronic/media/logos/logo-dark.png'), '/'));

        //toolbar
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

        $ktHeaderMobile->content($toolbar);

        $this->body->content($ktHeaderMobile);



        /**
         * Main Content
         */
        $mainContent = El::div('', 'kt-grid kt-grid--hor kt-grid--root');

        //page
        $page = El::div('', 'kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page');
        $wrapper = El::div('', 'kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper', 'kt_wrapper');





        /*------------------------------------------------------------------------------------------*/
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
        /*------------------------------------------------------------------------------------------*/





        /*header------------------------------------------------------------------------------------*/
        $header = El::div('', 'kt-header kt-grid__item  kt-header--fixed', 'kt_header');
        $headerWrapper = El::div('', 'kt-header-menu-wrapper', 'kt_header_menu_wrapper');
        $headerMenu = El::div('', 'kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default', 'kt_header_menu');

        $headerMenu->content($this->topMenu);
        $headerWrapper->content($headerMenu);
        $header->content( $headerWrapper );

        $toolbar = El::div($this->toolBar, 'kt-header__topbar');
        $header->content($toolbar);

        $wrapper->content($header);
        /*end header--------------------------------------------------------------------------------*/





        /*------------------------------------------------------------------------------------------*/
        $container = El::div('', 'kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor', 'kt_content');
        $subheader = El::div('', 'kt-subheader  kt-grid__item', 'kt_subheader');
        $subheaderContainer = El::div('', 'kt-container  kt-container--fluid');
        $subheaderMain = El::div('', 'kt-subheader__main');
        $subheaderMainTitle = El::H3($this->sub_header_title, 'kt-subheader__title');

        $subheaderMain->content($subheaderMainTitle);
        $subheaderMain->content(El::span('', 'kt-subheader__separator kt-hidden'));
        $subheaderMain->content($this->breadcrumb);


        $subheaderContainer->content($subheaderMain);
        //$subheaderContainer->content(El::div('test', 'kt-subheader__toolbar'));
        $subheader->content($subheaderContainer);
        $container->content($subheader);
        $container->content($this->getContent());
        $wrapper->content($container);
        /*------------------------------------------------------------------------------------------*/

        /*------------------------------------------------------------------------------------------*/

        /*------------------------------------------------------------------------------------------*/


        $page->content($wrapper);
        $mainContent->content($page);

        $this->body->content($mainContent);

        return parent::__toString();
    }

    public function sideMenu($menu)
    {
        $this->sideMenu = $menu;
        return $this;
    }

    public function topMenu($menu)
    {
        $this->topMenu = $menu;
        return $this;
    }

    public function toolBar($menu)
    {
        $this->toolBar = $menu;
        return $this;
    }

    public function subHeaderTitle($title)
    {
        $this->sub_header_title = $title;
        return $this;
    }

    public function breadCrumb($bc)
    {
        $this->breadcrumb = $bc;
        return $this;
    }

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

    public function addContent($content, $width)
    {
        if(($this->counter() + $width) > 12){
            $this->main_content[] = $this->row;
            $this->row = [];
        }
        $this->row[] = ["content" => $content, "width" => $width];
    }

    public function addContentTable($content, $width)
    {
        $this->script($content->getScript());
        $this->script($content->getSweetAlert());

        if(($this->counter() + $width) > 12){
            $this->main_content[] = $this->row;
            $this->row = [];
        }
        $this->row[] = ["content" => $content, "width" => $width];
    }

    public function getContent()
    {
        if(isset($this->row[0])){
            $this->main_content[] = $this->row;
            $this->row = [];
        }
        //<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
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
}
