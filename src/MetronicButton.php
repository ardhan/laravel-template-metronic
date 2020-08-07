<?php
namespace Ardhan\LaravelTemplateMetronic;
use Ardhan\LaravelSimpleHtml\Facades\Element as El;

class MetronicButton
{
    /**
     *----------------------------------------------------------------------------------------------
     * PARAMETER
     *----------------------------------------------------------------------------------------------
     */

    /**
     * caption pada tombol
     * @var string
     */
    private $caption = '';

    /**
     * url tujuan jika tombol merupakan link
     * @var string
     */
    private $url = '';

    /**
     * warna tombol: primary, danger, warning, success, info
     * @var string
     */
    private $color = '';

    /**
     * kelas pada tombol
     * @var array
     */
    private $cls = [];

    /**
     * attribut value: digunakan untuk sweetalert delete
     * @var string
     */
    private $value = '';

    /**
     * attribut value tanpa petik
     * @var string
     */
    private $value_no_quote = '';

    /**
     * button tanpa caption
     * @var string
     */
    private $icon_only = false;





    /**
     * ---------------------------------------------------------------------------------------------
     * METHOD
     * ---------------------------------------------------------------------------------------------
     */

    /**
     * konstruksi kelas
     * @param string $caption caption pada tombol
     * @param string $url     url target jika tombolnya berbentuk link
     * @param string $color   warna tombol
     */
    public function __construct($caption, $url = '', $color = '')
    {
        $this->caption = $caption;
        $this->url = $url;
        $this->color = ($color == '') ? 'primary' : $color;
        return $this;
    }


    /**
     * [url description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }


    /**
     * menentukan caption pada tombol
     * @param  string $caption caption pada tombol
     * @return object
     */
    public function caption($caption)
    {
        $this->caption = $caption;
        return $this;
    }


    /**
     * menentukan kelas pada tombol
     * @param  string $cls menentukan kelas pada tombol
     * @return object
     */
    public function cls($cls)
    {
        $this->cls[] = $cls;
        return $this;
    }


    /**
     * merbah ukuran tombol menjadi small
     * @return object
     */
    public function sm()
    {
        $this->cls[] = 'btn-sm';
        return $this;
    }


    /**
     * merubah ukuran tombol menjadi Large
     * @return object
     */
    public function lg()
    {
        $this->cls[] = 'btn-lg';
        return $this;
    }


    /**
     * membuat tombol tanpa caption / hanya icon saja
     * @return object
     */
    public function iconOnly()
    {
        $this->icon_only = true;
        $this->cls[] = 'btn-icon btn-outline-'.$this->color;
        return $this;
    }


    /**
     * menambahkan attribut value pada tombol
     * @param  string $value attribut value pada tombol
     * @return object
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }


    /**
     * menentukan attribut value tanpa petik pada tombol
     * @param  string $value nilai dari attirbut value
     * @return object
     */
    public function valueNoQuote($value)
    {
        $this->value_no_quote = $value;
        return $this;
    }


    /**
     * hasil tombol
     * @return string
     */
    public function __toString()
    {
        if($this->url == ''){
            $button = El::button($this->caption)->cls('btn');
        }else{
            $button = El::a($this->caption, $this->url)->cls('btn');
        }

        if($this->icon_only == false){
            $button->cls('btn-'.$this->color);
        }

        if($this->value != ''){
            $button->attr('value', $this->value);
        }

        if($this->value_no_quote != ''){
            $button->attrNoQuote('value', $this->value_no_quote);
        }

        //resolve class
        if(count($this->cls) > 0){
            foreach($this->cls as $c){
                $button->cls($c);
            }
        }

        return $button->__toString();
    }

}
