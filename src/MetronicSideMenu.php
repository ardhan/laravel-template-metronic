<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicSideMenu
{
    private $item = [];
    private $submenu = null;
    private $active = -1;

    public function __construct()
    {
        return $this;
    }


    public function item($caption, $url, $icon = '', $submenu = '')
    {
        $this->item[] = [
            "caption" => $caption,
            "url" => $url,
            "icon" => $icon,
            "active" => false,
            "submenu" => $submenu
        ];
        return $this;
    }

    public function submenu($submenu)
    {
        $this->item[count($this->item) - 1]["submenu"] = $submenu;
        return $this;
    }

    public function active()
    {
        $this->item[count($this->item) - 1]["active"] = true;
        return $this;
    }

    public function get()
    {
    }

    public function resolve()
    {
        $asideMenu = El::div('', 'kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid', 'kt_aside_menu_wrapper');

            $asideMenuContainer = El::div('', 'kt-aside-menu', 'kt_aside_menu')
                ->attr('data-menu-vertical', '1')
                ->attr('data-menu-scroll', '1')
                ->attr('data-menu-dropdown-timeout', '500');

            $menu = El::ls()->cls('kt-menu__nav');
            foreach($this->item as $item){
                if($item["submenu"] == ''){
                    $li = El::li(
                        El::a(
                            El::span(Metronic::svg($item["icon"]), 'kt-menu__link-icon').
                            El::span($item["caption"], 'kt-menu__link-text')
                            , $item["url"], 'kt-menu__link'
                        ),
                        'kt-menu__item'
                    )->attr("aria-haspopup", "true");
                    if($item["active"] == true) $li->cls('kt-menu__item--active');
                    $menu->content($li);
                }else{
                    $menu->content($this->resolveSubMenu($item));
                }

            }
            $asideMenuContainer->content($menu);

        $asideMenu->content($asideMenuContainer);

        return $asideMenu->__toString();
    }

    public function resolveSubMenu($item)
    {
        $toggler = El::a(
            El::span(Metronic::svg($item["icon"]), 'kt-menu__link-icon').
            El::span($item["caption"], 'kt-menu__link-text').
            El::i('kt-menu__ver-arrow la la-angle-right')
            , 'javascript:;', 'kt-menu__link kt-menu__toggle'
        );

        $ul = El::ls()->cls('kt-menu__subnav');

        //<li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
        $ul->content(
            El::li(
                El::span(
                    El::span($item["caption"], 'kt-menu__link-text')
                    ,'kt-menu__link')
                , 'kt-menu__item kt-menu__item--parent'
            )->attr('aria-haspopup', 'true')
        );

        foreach($item["submenu"]->item as $s){

            $li = El::li(
                    El::a(
                        El::i('kt-menu__link-bullet kt-menu__link-bullet--dot')->content(El::span()).
                        El::span($s['caption'], 'kt-menu__link-text')
                        , $s['url'], 'kt-menu__link'
                    )
                    , 'kt-menu__item')->attr('aria-haspopup', 'true');
            if($s["active"] == true) $li->cls('kt-menu__item--active');
            $ul->content($li);
        }


        $submenu = El::div(
            El::span('', 'kt-menu__arrow') . $ul
            , 'kt-menu__submenu'
        );


        $li = El::li(
            $toggler . $submenu
            , 'kt-menu__item kt-menu__item--submenu'
        )->attr('aria-haspopup', true)->attr('data-ktmenu-submenu-toggle', 'hover');

        if($item["active"] == true) $li->cls('kt-menu__item--open kt-menu__item--here');

        return $li;
    }


    public function __toString()
    {
        return $this->resolve();
    }
}
