<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/6
 * Time: 9:47 AM
 */

namespace Ecjia\App\Platform\Frameworks\Controller;

use ecjia_front;
use RC_Plugin;
use Royalcms\Component\Support\Traits\Macroable;

class PluginPageController
{

    use Macroable;

    protected $__FILE__;

    public function __construct()
    {

    }


    public function setPluginPath($path)
    {
        $this->__FILE__ = $path;

        return $this;
    }

    public function assginPluginStyleUrl($name, $path)
    {
        ecjia_front::$controller->assign($name, RC_Plugin::plugins_url($path, $this->__FILE__));

        return $this;
    }

    /**
     * 获取插件内的文件路径
     * @param $page
     * @return string
     */
    public function getPluginFilePath($path)
    {
        return RC_Plugin::plugin_dir_path($this->__FILE__) . $path;
    }

    /**
     * 错误消息模板
     */
    public function showErrorMessage($msg = null)
    {
        ecjia_front::$controller->assign('msg', $msg);
        return ecjia_front::$controller->displayAppTemplate('platform', 'front/plugin_page_showerror.dwt');
    }


    /**
     * 跳转
     * @param $url
     */
    public function redirect($url)
    {
        ecjia_front::$controller->redirect($url);
        ecjia_front::$controller->exited();
    }

}