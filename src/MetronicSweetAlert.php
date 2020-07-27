<?php
/*$('#kt_sweetalert_demo_9').click(function(e) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result){
                if (result.value) {
                    swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    // result.dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                } else if (result.dismiss === 'cancel') {
                    swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
        });*/
        namespace Ardhan\LaravelTemplateMetronic;
        use Ardhan\LaravelSimpleHtml\Page;
        use Ardhan\LaravelSimpleHtml\Facades\Element as El;
        use Ardhan\LaravelTemplateMetronic\Facades\Metronic;

class MetronicSweetAlert
{
    private $selector = '';
    private $text = '';
    private $title = '';
    private $type = 'warning';
    private $cancel = true;
    private $caption_ok = 'Yakin';
    private $caption_cancel = 'Batal';

    public function __construct($selector = '')
    {
        $this->selector = $selector;
        return $this;
    }

    public function selector($selector)
    {
        $this->selector = $selector;
        return $this;
    }

    public function getSelector()
    {
        return $this->selector;
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    public function __toString()
    {
        $swal = [
            'title' => $this->title,
            'text' => $this->text,
            'type' => $this->type,
            'showCancelButton' => $this->cancel,
            'confirmButtonText'=> $this->caption_ok,
            'cancelButtonText' => $this->caption_cancel,
            'reverseButtons' => true
        ];

        $sc = 'swal.fire('.json_encode($swal).');';

        return $sc;
    }
}
