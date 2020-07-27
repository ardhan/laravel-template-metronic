<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Page;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;
use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicTopMenu
{
    private $item = [];
    private $caption;
    private $active = false;

    public function __construct($caption, $active  = false)
    {
        $this->caption = $caption;
        $this->active = $active;
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


    public function resolve()
    {
        $menu = El::ls()->cls('kt-menu__nav');

        $submenuContainer = El::div('', 'kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left');

        $submenu = El::ls()->cls('kt-menu__subnav');
        foreach($this->item as $item){
            //

            $li = El::li(
                El::a(
                    El::span(Metronic::svg($item["icon"]),'kt-menu__link-icon').El::span('Test', 'kt-menu__link-text'),
                    '/', 'kt-menu__link'
                )
            )->cls('kt-menu__item')->attr('aria-haspopup', 'true');

            if($item["active"] == true) $li->cls('kt-menu__item--active');

            $submenu->content($li);
        }


        $submenuContainer->content($submenu);
        $main_li = El::li(
            El::a(
                El::span($this->caption, 'kt-menu__link-text').El::i('kt-menu__ver-arrow la la-angle-right'),
                'javascript:;', 'kt-menu__link kt-menu__toggle'
            ).$submenuContainer
            , 'kt-menu__item kt-menu__item--submenu kt-menu__item--rel '
        )->attr('data-ktmenu-submenu-toggle','click')->attr('aria-haspopup', 'true');

        $menu->content( $main_li);

        //kt-menu__item--open kt-menu__item--here kt-menu__item--active

        return $menu->__toString();
    }


    public function resolveSubMenu()
    {

    }


    public function __toString()
    {
        return $this->resolve();
    }
}
