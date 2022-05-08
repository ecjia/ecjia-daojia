<?php


namespace Ecjia\App\Upgrade\BrowserEvent;


use Ecjia\Component\BrowserEvent\BrowserEventInterface;
use RC_Script;

class InstallStartEvent implements BrowserEventInterface
{

    public function __construct()
    {
        RC_Script::enqueue_script('smoke');
    }

    public function __invoke()
    {
        $ecjia_lang = [
            'ok'             => __('确定', 'upgrade'),
            'latest_version' => __('当前版本已是最新版', 'upgrade'),
        ];
        $ecjia_lang = json_encode($ecjia_lang);

        return <<<JS
(function () {
    $('#ecjia_upgrade').click(function() {
        let js_lang = {$ecjia_lang};
        let version_current = $('input[name="version_current"]').val();
        let version_last = $('input[name="version_last"]').val();
        //验证是否确认覆盖数据库
        if (version_current === version_last) {
            smoke.alert(js_lang.latest_version, {
                ok: js_lang.ok
            });
            return false;
        }
        
        let middleware = ecjia.middleware();
        middleware.use(ecjia.front.task.startingTask);
        middleware.use(ecjia.front.task.upgradeTask);
        middleware.use(ecjia.front.task.upgradeFinishTask);
        middleware.handleRequest();
    });
})();
JS;
    }

}