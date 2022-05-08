<?php


namespace Ecjia\System\Frameworks\BrowserEvent;


class SwitchClickEvent
{

    public function __invoke()
    {
        return <<<JS
(function () {
    $('.switch').on('click', function (e) {
        var url = $(this).attr('data-url');
        $.get(url, function(data) {
            ecjia.admin.showmessage(data);
        });
    });
})();
JS;

    }

}