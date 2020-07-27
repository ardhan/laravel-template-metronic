<?php
namespace Ardhan\LaravelTemplateMetronic;

class Metronic
{
    public function page()
    {
        return new MetronicPage();
    }

    public function sideMenu()
    {
        return new MetronicSideMenu();
    }

    public function sideMenuSub()
    {
        return new MetronicSideMenu();
    }

    public function topMenu($caption)
    {
        return new MetronicTopMenu($caption);
    }

    public function svg($name)
    {
        return new MetronicSvg($name);
    }

    public function toolbar()
    {
        return new MetronicToolbar();
    }

    public function BreadCrumb()
    {
        return new MetronicBreadCrumb();
    }

    public function Portlet($title, $content = '')
    {
        return new MetronicPortlet($title, $content);
    }

    public function Form($title, $action, $method = 'POST')
    {
        return new MetronicForm($title, $action, $method);
    }

    public function Button($caption, $url = '', $color = '')
    {
        return new MetronicButton($caption, $url, $color);
    }

    public function Table($title)
    {
        return new MetronicTable($title);
    }

    public function IconFti($icon)
    {
        return MetronicIcon::fti($icon);
    }

    public function IconFti2($icon)
    {
        return MetronicIcon::fti2($icon);
    }

    public function IconFa($icon)
    {
        return MetronicIcon::fa($icon);
    }

    public function IconFab($icon)
    {
        return MetronicIcon::fab($icon);
    }


    public function SweetAlert($selector)
    {
        return new MetronicSweetAlert($selector);
    }
}
