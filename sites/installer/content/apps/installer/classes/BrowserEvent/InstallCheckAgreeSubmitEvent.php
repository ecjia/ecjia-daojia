<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class InstallCheckAgreeSubmitEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue_script('jquery-form');
    }

    public function __invoke()
    {
        return <<<JS
(function () {
    //判断用户是否同意协议
    $('#install_check_agree').on('submit', function(event) {
        event.preventDefault();
        let that = $(this);
        that.ajaxSubmit({
            dataType: "json",
            success: function(data) {
                if (data.state === 'success') {
                    window.location.href = data.url;
                } else {
                    var alter_info = $('<div class="staticalert alert alert-error ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
                    alter_info.appendTo('.error-msg').delay(5000).hide(0);
                }
            }
        });
    });
})();
JS;

    }

}