<?php


namespace Ecjia\App\Rpc\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;

class GenerateTokenEvent implements BrowserEventInterface
{

    public function __construct()
    {

    }

    public function __invoke()
    {
        return <<<JS
(function () {
    $('.toggle_view').on('click', function (event) {
        event.preventDefault();
        let that = $(this);
        let url = that.attr('href');
        let val = that.attr('data-val') || 'allow';
        let data = {
            check: val
        }
        $.post(url, data, function (data) {
            if (data.state === 'success') {
                $('.generate_token').val(data.token);
            }
            ecjia.admin.showmessage(data);
        }, 'json');
    });
})();
JS;

    }

}