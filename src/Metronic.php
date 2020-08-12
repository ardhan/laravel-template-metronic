<?php
namespace Ardhan\LaravelTemplateMetronic;

class Metronic
{
    /**
     * ---------------------------------------------------------------------------------------------
     * Kompenen Halaman
     * ---------------------------------------------------------------------------------------------
     */

    /**
     * membuat halaman baru
     * @return object
     */
    public function page()
    {
        return new MetronicPage();
    }


    /**
     * membuat kelas sidemenu
     * @return object
     */
    public function sideMenu()
    {
        return new MetronicSideMenu();
    }


    /**
     * membuat kelas sub side menu
     * @return object
     */
    public function sideMenuSub()
    {
        return new MetronicSideMenu();
    }


    /**
     * membuat kelas top menu
     * @return object
     */
    public function topMenu($caption)
    {
        return new MetronicTopMenu($caption);
    }


    /**
     * membuat kelas toolbar
     * @return object
     */
    public function toolbar()
    {
        return new MetronicToolbar();
    }


    /**
     * membuat kelas breadcrumb
     * @return object
     */
    public function BreadCrumb()
    {
        return new MetronicBreadCrumb();
    }


    /**
     * membuat kelas portlet
     * @return object
     */
    public function Portlet($title, $content = '')
    {
        return new MetronicPortlet($title, $content);
    }





    /**
     * ---------------------------------------------------------------------------------------------
     * Button dan Icon
     * ---------------------------------------------------------------------------------------------
     */

    /**
     * membuat tombol
     * @param string $caption caption pada button
     * @param string $url     url jika berbentuk link
     * @param string $color   warna
     */
    public function Button($caption, $url = '', $color = '')
    {
        return new MetronicButton($caption, $url, $color);
    }


    /**
     * membuat icon svg
     * @return object
     */
    public function svg($name)
    {
        return new MetronicSvg($name);
    }


    /**
     * membuat icon flaticon-$icon
     * @param string $icon nama icon
     */
    public function IconFti($icon)
    {
        return MetronicIcon::fti($icon);
    }


    /**
     * membuat icon flaticon2-$icon
     * @param string $icon nama icon
     */
    public function IconFti2($icon)
    {
        return MetronicIcon::fti2($icon);
    }


    /**
     * membuat icon fontawesome
     * @param string $icon nama fa fa-$icon
     */
    public function IconFa($icon)
    {
        return MetronicIcon::fa($icon);
    }


    /**
     * membuat icon fontawesome
     * @param string $icon nama fab fa-$icon
     */
    public function IconFab($icon)
    {
        return MetronicIcon::fab($icon);
    }




    /**
     * ---------------------------------------------------------------------------------------------
     * Form
     * ---------------------------------------------------------------------------------------------
     */
    public function Form($title, $action, $method = 'POST')
    {
        return new MetronicForm($title, $action, $method);
    }




    /**
     * ---------------------------------------------------------------------------------------------
     * Table
     * ---------------------------------------------------------------------------------------------
     */
    public function Table($title, $server = '')
    {
        return new MetronicTable($title, $server);
    }

    public function TableServer($data)
    {
        return new MetronicTableServer($data);
    }

    public function SweetAlert($selector)
    {
        return new MetronicSweetAlert($selector);
    }


}
