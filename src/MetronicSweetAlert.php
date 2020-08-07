<?php
namespace Ardhan\LaravelTemplateMetronic;

class MetronicSweetAlert
{
    /**
     * nama kelas yang menjadi selector
     * @var string
     */
    private $selector = '';

    /**
     * judul pada modal yang muncul
     * @var string
     */
    private $title = '';

    /**
     * isi notifikasi
     * @var string
     */
    private $text = '';

    /**
     * url yang menjadi tujuan setelah user ok
     * @var string
     */
    private $url = '';

    /**
     * jenis notifikasi
     * @var string
     */
    private $type = 'warning';

    /**
     * munculkan tombol batal
     * @var boolean
     */
    private $cancel = true;

    /**
     * caption untuk tombol ok
     * @var string
     */
    private $caption_ok = 'Yakin';

    /**
     * caption untuk tombol batal
     * @var [type]
     */
    private $caption_cancel = 'Batal';


    /**
     * konstruksi kelas
     * @param string $selector kelas yang menjadi selector
     */
    public function __construct($selector = '')
    {
        $this->selector($selector);
        return $this;
    }


    /**
     * menentukan selector
     * @param  string $selector kelas yang menjadi selector
     * @return object
     */
    public function selector($selector)
    {
        $this->selector = $selector;
        return $this;
    }


    /**
     * mendapatkan selector
     * @return string selector
     */
    public function getSelector()
    {
        return $this->selector;
    }


    /**
     * menentukan judul
     * @param  string $title judul alert
     * @return object
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * menentukan isi alert
     * @param  string $text isi alert
     * @return object
     */
    public function text($text)
    {
        $this->text = $text;
        return $this;
    }


    /**
     * menentukan url tujuan
     * @param  string $url url yang menjadi tujuan
     * @return object
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }


    /**
     * hasil
     * @return string javascript sweet alert
     */
    public function __toString()
    {
        $pre_confirm_then = 'then(response => {if(!response.ok){console.log(\'tidak ok\');} return response.json();}).catch(error => {console.log(error);})';
        $method = '{method:\'DELETE\', headers:{\'X-CSRF-TOKEN\': \''.csrf_token().'\'}}'

        $swal = [
            'title' => $this->title,
            'text' => $this->text,
            'type' => $this->type,
            'showCancelButton' => $this->cancel,
            'confirmButtonText'=> $this->caption_ok,
            'cancelButtonText' => $this->caption_cancel,
            '*preConfirm*' => '*function(){return fetch(\''.$this->url.'\'+value, '.$method.'). '.$pre_confirm_then.'}*'
        ];

        $swalencode = json_encode($swal);
        $swalencode = str_replace('"*', '', $swalencode);
        $swalencode = str_replace('*"', '', $swalencode);

        $fire_notif = 'console.log(result);Swal.fire(result.title, result.value.text, result.value.icon);';
        $after_fire = '.then (result => { if(!result.dismiss){ datatable.reload(); '.$fire_notif.'} });';

        $sc = 'var value= $(this).attr("value");';
        $sc .= 'swal.fire('.$swalencode.')'.$after_fire;

        return $sc;
    }
}
