<?php


namespace Ecjia\App\Installer\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;

class AgreeChangeEvent implements BrowserEventInterface
{

    public function __construct()
    {

    }

    public function __invoke()
    {
        return <<<JS
(function () {
    //判断用户是否同意协议
    $("#agree").change(function() {
        if ($("#agree").prop("checked")) {
            $.cookie('install_agree', 1);
            $("#ecjia_install").attr('disabled',false); //按钮可用
        } else {
            $.cookie('install_agree', null);
            $("#ecjia_install").attr('disabled',true); //按钮不可用
        }
    });
})();
JS;

    }

}