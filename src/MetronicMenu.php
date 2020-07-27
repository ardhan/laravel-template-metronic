<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use MetronicSvg as Svg;

class MetronicMenu
{
    private $item = [];
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

    public function active()
    {
        $this->item[count($this->item) - 1]["active"] = true;
        return $this;
    }

    public function get()
    {
    }


    public function __toString()
    {
        $asideMenu = El::div('', 'kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid', 'kt_aside_menu_wrapper');

            $asideMenuContainer = El::div('', 'kt-aside-menu', 'kt_aside_menu')
                ->attr('data-menu-vertical', '1')
                ->attr('data-menu-scroll', '1')
                ->attr('data-menu-dropdown-timeout', '500');

            $menu = El::ls()->cls('kt-menu__nav');
            foreach($this->item as $item){
                $li = El::li(
                    El::a(
                        El::span(Svg::Layer(), 'kt-menu__link-icon').
                        El::span($item["caption"], 'kt-menu__link-text')
                        , '/', 'kt-menu__link'
                    ),
                    'kt-menu__item'
                )->attr("aria-haspopup", "true");
                if($item["active"] == true) $li->cls('kt-menu__item--active');
                $menu->content($li);
            }
            $asideMenuContainer->content($menu);

        $asideMenu->content($asideMenuContainer);

        return $asideMenu->__toString();
    }
}
