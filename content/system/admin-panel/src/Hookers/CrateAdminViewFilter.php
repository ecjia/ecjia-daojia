<?php


namespace Ecjia\System\AdminPanel\Hookers;


class CrateAdminViewFilter
{

    /**
     * Handle the event.
     * hook:activated_application
     * @return void
     */
    public function handle($view)
    {
        $adminDir = realpath(__DIR__ . '/../../templates');

        // 模板目录
        $view->addTemplateDir($adminDir . DIRECTORY_SEPARATOR);
        // 添加主题插件目录
        $view->addPluginsDir($adminDir . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR);

        return $view;
    }

}